<?php

declare(strict_types=1);

namespace App\Domain\ExchangeRate\Service;

use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;

interface CurrencyConverterInterface
{
    public function convert(
        Currency $sourceCurrency,
        Currency $targetCurrency,
        MoneyAmount $amount
    ): MoneyAmount;
}
