<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\WalletNotFoundException;
use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\Model\Wallet as DomainWallet;
use App\Domain\Wallet\Repository\WalletRepositoryInterface;
use App\Domain\Wallet\ValueObject\Money;
use App\Infrastructure\Persistence\Doctrine\Repository\WalletRepository;

final readonly class WalletService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
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
}
