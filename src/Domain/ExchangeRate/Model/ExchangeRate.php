<?php

namespace App\Domain\ExchangeRate\Model;

use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use DateTimeImmutable;

final readonly class ExchangeRate
{
    public function __construct(
        public Currency $baseCurrency,
        public Currency $targetCurrency,
        public MoneyAmount $rate,
        public DateTimeImmutable $date,
    ) {
    }

    public static function create(
        Currency $baseCurrency,
        Currency $targetCurrency,
        MoneyAmount $rate,
        ?DateTimeImmutable $date = null,
    ): ExchangeRate {
        if ($date === null) {
            $date = new DateTimeImmutable('now');
        }

        return new ExchangeRate(
            $baseCurrency,
            $targetCurrency,
            $rate,
            $date,
        );
    }
}
