<?php

namespace App\Http\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class MakeBalanceChangeInputDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Transaction type should not be blank')]
        #[Assert\GreaterThan(0, message: 'Transaction type should not be blank')]
        public int $walletId,
        #[Assert\NotBlank(message: 'Type should not be blank')]
        public string $type,
        #[Assert\NotBlank(message: 'Transaction type should not be blank')]
        #[Assert\Positive(message: 'Transaction type should not be blank')]
        #[Assert\Type('numeric')]
        public float $amount,
        #[Assert\NotBlank(message: 'Transaction type should not be blank')]
        public string $currency,
        #[Assert\NotBlank(message: 'Transaction type should not be blank')]
        public string $reason,
    ) {
    }
}
