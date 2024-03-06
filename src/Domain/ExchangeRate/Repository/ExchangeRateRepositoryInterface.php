<?php

namespace App\Domain\ExchangeRate\Repository;

use App\Domain\ExchangeRate\Model\ExchangeRate;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;

interface ExchangeRateRepositoryInterface
{
    public function findRate(
        Currency $sourceCurrency,
        Currency $targetCurrency
    ): ?MoneyAmount;

    public function save(ExchangeRate $exchangeRate): void;
}
