<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Repository;

use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\ValueObject\WalletId;

interface WalletRepositoryInterface
{
    public function findOneById(WalletId $walletId): ?Wallet;
}
