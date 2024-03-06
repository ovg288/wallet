<?php

declare(strict_types=1);

namespace App\Domain\Wallet\ValueObject;

class WalletId
{
    public function __construct(
        public readonly int $walletId
    ) {
        // todo validate rules
    }

    public static function create(int $walletId): WalletId
    {
        return new WalletId($walletId);
    }
}
