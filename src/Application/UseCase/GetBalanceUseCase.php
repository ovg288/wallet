<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\WalletNotFoundException;
use App\Domain\Wallet\Repository\WalletRepositoryInterface;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\WalletId;

final readonly class GetBalanceUseCase implements GetBalanceUseCaseInterface
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {
    }

    /**
     * @param int $walletId
     * @return Money
     * @throws WalletNotFoundException
     */
    public function execute(int $walletId): Money
    {
        $wallet = $this->walletRepository->findOneById(
            walletId: new WalletId($walletId)
        );

        if (!$wallet) {
            throw new WalletNotFoundException();
        }

        return $wallet->getBalance();
    }
}
