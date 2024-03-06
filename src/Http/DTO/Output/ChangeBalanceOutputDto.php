<?php

namespace App\Http\DTO\Output;

class ChangeBalanceOutputDto
{
    public function __construct(
        public float $amount,
        public string $wallet,
    ) {
    }
}
