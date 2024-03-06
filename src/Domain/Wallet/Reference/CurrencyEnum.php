<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Reference;

enum CurrencyEnum: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case RUB = 'RUB';
}
