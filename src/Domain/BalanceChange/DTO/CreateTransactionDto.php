<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\DTO;

use App\Domain\BalanceChange\Reference\BalanceChangeReasonEnum;
use App\Domain\Wallet\Reference\CurrencyEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateTransactionDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThan(0)]
        public int $walletId,
        #[Assert\Type(CurrencyEnum::class)]
        public string $transactionType,
        #[Assert\Positive]
        public float $amount,
        #[Assert\Type(CurrencyEnum::class)]
        public string $currency,
        #[Assert\Type(BalanceChangeReasonEnum::class)]
        public string $reason,
    ) {
    }
}
