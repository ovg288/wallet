<?php

declare(strict_types=1);

namespace App\Domain\Wallet\ValueObject;

use App\Domain\Wallet\Exception\NegativeAmountException;

final readonly class MoneyAmount
{
    /**
     * @throws NegativeAmountException
     */
    public function __construct(
        private float $amount
    ) {
        if ($amount <= .0) {
            throw new NegativeAmountException();
        }
    }

    public function amount(): float
    {
        return (float)number_format($this->amount, 2, '.', '');
    }

    /**
     * @throws NegativeAmountException
     */
    public static function create(float $amount): MoneyAmount
    {
        return new MoneyAmount($amount);
    }

    /**
     * @throws NegativeAmountException
     */
    public function multiply(float $multiplier): MoneyAmount
    {
        return new MoneyAmount($this->amount * $multiplier);
    }
}
