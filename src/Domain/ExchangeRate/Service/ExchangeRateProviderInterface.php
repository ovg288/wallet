<?php

namespace App\Domain\ExchangeRate\Service;

use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use DateTimeImmutable;

interface ExchangeRateProviderInterface
{
    public function fetchRate(
        Currency $sourceCurrency,
        Currency $targetCurrency,
        ?DateTimeImmutable $dateTime = null
    ): MoneyAmount;
}
