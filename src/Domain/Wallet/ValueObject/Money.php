<?php

declare(strict_types=1);

namespace App\Domain\Wallet\ValueObject;

use App\Domain\Wallet\Exception\NegativeAmountException;
use InvalidArgumentException;

final readonly class Money
{
    /**
     * @throws NegativeAmountException
     */
    public function __construct(
        private MoneyAmount $amount,
        private Currency $currency,
    ) {
        if ($amount->amount() <= 0) {
            throw new NegativeAmountException('Amount must be a positive integer');
        }
    }

    public function getAmount(): MoneyAmount
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    protected function validateCurrencies(Currency $baseCurrency, Currency $counterCurrency): bool
    {
        return $baseCurrency->equalsTo($counterCurrency);
    }

    /**
     * @throws NegativeAmountException
     */
    public function add(Money $money): Money
    {
        if (!$this->currency->equalsTo($money->getCurrency())) {
            throw new InvalidArgumentException('Currencies must be the same. Wallet currency: ' . $this->currency);
        }

        return new Money(
            MoneyAmount::create($this->amount->amount() + $money->getAmount()->amount()),
            $this->currency
        );
    }

    /**
     * @throws NegativeAmountException
     */
    public function subtract(Money $money): Money
    {
        if (!$this->currency->equalsTo($money->getCurrency())) {
            throw new InvalidArgumentException('Currencies must be the same. Wallet currency: ' . $this->currency);
        }

        // @todo Validate result

        return new Money(
            MoneyAmount::create($this->amount->amount() - $money->getAmount()->amount()),
            $this->currency
        );
    }

    public function equals(Money $money): bool
    {
        return $this->amount === $money->getAmount() && $this->currency === $money->getCurrency();
    }

    public static function create(
        MoneyAmount $amount,
        Currency $currency,
    ): Money {
        return new Money(
            $amount,
            $currency,
        );
    }
}
