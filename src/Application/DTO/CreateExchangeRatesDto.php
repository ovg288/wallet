<?php

namespace App\Application\DTO;

use DateTimeImmutable;

final readonly class CreateExchangeRatesDto
{
    public function __construct(
        public array $currencies,
        public DateTimeImmutable $createdAt,
    ) {
    }
}
