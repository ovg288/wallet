<?php

namespace App\Http\DTO\Output;

final readonly class WalletGetBalanceOutputDto
{
    public function __construct(
        public float $amount,
        public string $currency,
    ) {
    }
}
