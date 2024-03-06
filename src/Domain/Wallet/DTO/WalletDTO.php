<?php

namespace App\Domain\Wallet\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class WalletDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThan(0)]
        public int $id,
    ) {
    }
}
