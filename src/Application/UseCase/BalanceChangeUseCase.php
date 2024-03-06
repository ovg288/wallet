<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\WalletNotFoundException;
use App\Application\Service\WalletChangeMoneyServiceInterface;
use App\Domain\BalanceChange\Model\BalanceChange;
use App\Domain\BalanceChange\Repository\BalanceChangeRepositoryInterface;
use App\Domain\BalanceChange\Service\BalanceChangeMakerMoneyServiceInterface;
use App\Domain\BalanceChange\Service\SimpleBalanceChangeMakerMoneyService;
use App\Domain\BalanceChange\ValueObject\BalanceChangeReason;
use App\Domain\BalanceChange\ValueObject\BalanceChangeType;
use App\Domain\ExchangeRate\Service\CurrencyConverterInterface;
use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\Exception\UnknownWalletBalanceChangeTypeException;
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
        private BalanceChangeMakerMoneyServiceInterface $balanceChangeMakerMoneyService,
        private WalletChangeMoneyServiceInterface $walletChangeMoneyService,
    ) {
    }

    /**
     * @throws WalletNotFoundException
     * @throws NegativeAmountException
     * @throws UnknownWalletBalanceChangeTypeException
     * @throws UnknownCurrencyException
     */
    public function execute(
        MakeBalanceChangeInputDto $balanceChangeInputDto,
    ): Wallet {
        $wallet = $this->walletRepository->findOneById(
            WalletId::create($balanceChangeInputDto->walletId)
        );

        if (!$wallet) {
            throw new WalletNotFoundException();
        }

        $balanceChangeMoney = Money::create(
            MoneyAmount::create($balanceChangeInputDto->amount),
            Currency::create($balanceChangeInputDto->currency),
        );

        $balanceChangeMoney = $this->balanceChangeMakerMoneyService->createMoney(
            $wallet,
            $balanceChangeMoney,
        );

        /**
         * История с сохранением транзакции вынесена в доменные сервисы,
         * поскольку она содержит бизнес-логику принятия решения, в
         * какой валюте сохранять balance_changes.
         */
        $balanceChange = BalanceChange::create(
            $wallet,
            $balanceChangeMoney,
            BalanceChangeType::create($balanceChangeInputDto->type),
            BalanceChangeReason::create($balanceChangeInputDto->reason),
        );

        $walletChangeMoney = $this->walletChangeMoneyService->createMoney(
            $wallet,
            $balanceChangeMoney
        );

        /**
         * Пересчитываем баланс Wallet
         */
        $wallet->changeMoney($balanceChangeInputDto->type, $walletChangeMoney);

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
