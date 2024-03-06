<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\WalletNotFoundException;
use App\Domain\BalanceChange\Model\BalanceChange;
use App\Domain\BalanceChange\Repository\BalanceChangeRepositoryInterface;
use App\Domain\BalanceChange\ValueObject\BalanceChangeReason;
use App\Domain\BalanceChange\ValueObject\BalanceChangeType;
use App\Domain\ExchangeRate\Service\CurrencyConverterInterface;
use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\Repository\WalletRepositoryInterface;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use App\Domain\Wallet\ValueObject\WalletId;
use App\Http\DTO\Input\MakeBalanceChangeInputDto;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final readonly class BalanceChangeUseCase implements BalanceChangeUseCaseInterface
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository,
        private BalanceChangeRepositoryInterface $balanceChangeRepository,
        private EntityManagerInterface $entityManager,
        private CurrencyConverterInterface $currencyConverter,
    ) {
    }

    public function execute(
        MakeBalanceChangeInputDto $balanceChangeInputDto,
    ): Wallet {
        $wallet = $this->walletRepository->findOneById(
            WalletId::create($balanceChangeInputDto->walletId)
        );

        if (!$wallet) {
            throw new WalletNotFoundException();
        }

        if ((string)$wallet->getBalance()->getCurrency() !== $balanceChangeInputDto->currency) {
            $amount = $this->currencyConverter->convert(
                Currency::create($balanceChangeInputDto->currency),
                $wallet->getBalance()->getCurrency(),
                MoneyAmount::create($balanceChangeInputDto->amount)
            );

            $money = Money::create(
                $amount,
                $wallet->getBalance()->getCurrency(),
            );
        } else {
            $money = Money::create(
                MoneyAmount::create($balanceChangeInputDto->amount),
                Currency::create($balanceChangeInputDto->currency),
            );
        }

        // Создаем ChangeBalance
        $balanceChange = BalanceChange::create(
            $wallet,
            $money,
            BalanceChangeType::create($balanceChangeInputDto->type),
            BalanceChangeReason::create($balanceChangeInputDto->reason),
        );

        // Пересчитываем баланс Wallet
        $wallet->changeMoney($balanceChangeInputDto->type, $money);

        try {
            $this->entityManager->beginTransaction();

            $walletEntity = $this->walletRepository->setBalance($wallet);

            $this->balanceChangeRepository->create($balanceChange, $walletEntity);

            $this->entityManager->commit();
        } catch (Exception $exception) {
            $this->entityManager->rollback();
            throw new Exception('Save transaction exception: ' . $exception->getMessage());
        }

        return $wallet;
    }
}
