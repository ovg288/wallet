<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\WalletNotFoundException;
use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\Model\Wallet as DomainWallet;
use App\Domain\Wallet\ValueObject\Money;
use App\Infrastructure\Persistence\Doctrine\Repository\WalletRepository;

final readonly class WalletService
{
    public function __construct(
        private WalletRepository $walletRepository
    ) {
    }

    /**
     * @param DomainWallet $domainWallet
     *
     * @return void
     */
    public function createWallet(DomainWallet $domainWallet): void
    {
        // @refactor Должно быть проведено через доменный слой
        $this->walletRepository->save($domainWallet);
    }

    /**
     * @param int $walletId
     *
     * @return Money
     *
     * @throws NegativeAmountException
     * @throws UnknownCurrencyException
     * @throws WalletNotFoundException
     */
    public function getBalance(
        int $walletId,
    ): Money {
        $wallet = $this->walletRepository->findById($walletId);
        if (!$wallet) {
            throw new WalletNotFoundException();
        }

        return $wallet->getBalance();
    }
}
