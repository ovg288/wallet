<?php

declare(strict_types=1);

namespace App\Domain\Wallet\ValueObject;

use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\Reference\CurrencyEnum;

final readonly class Currency
{
    /**
     * @throws UnknownCurrencyException
     */
    public function __construct(
        private string $currency
    ) {
        if (!CurrencyEnum::tryFrom($this->currency)) {
            throw new UnknownCurrencyException();
        }
    }

    public function __toString(): string
    {
        return $this->currency;
    }

    /**
     * @throws UnknownCurrencyException
     */
    public static function create(string $currency): Currency
    {
        return new Currency($currency);
    }

    public function equalsTo(Currency $currency): bool
    {
        return strtolower((string)$this) === strtolower((string)$currency);
    }
}
