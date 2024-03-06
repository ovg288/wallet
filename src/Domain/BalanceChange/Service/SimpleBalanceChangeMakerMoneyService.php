<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\Service;

use App\Domain\ExchangeRate\Service\CurrencyConverterInterface;
use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use Override;

class SimpleBalanceChangeMakerMoneyService implements BalanceChangeMakerMoneyServiceInterface
{
    public function __construct(
        private CurrencyConverterInterface $currencyConverter,
    ) {
    }

    #[Override] public function createMoney(
        Wallet $wallet,
        Money $balanceChangeMoney
    ): Money {
        if (!$wallet->getBalance()->getCurrency()->equalsTo($balanceChangeMoney->getCurrency())) {
            $amount = $this->currencyConverter->convert(
                Currency::create((string)$balanceChangeMoney->getCurrency()),
                $wallet->getBalance()->getCurrency(),
                MoneyAmount::create($balanceChangeMoney->getAmount()->amount())
            );

            $money = Money::create(
                $amount,
                $wallet->getBalance()->getCurrency(),
            );
        } else {
            $money = Money::create(
                MoneyAmount::create($balanceChangeMoney->getAmount()->amount()),
                Currency::create((string)$balanceChangeMoney->getCurrency()),
            );
        }

        return $money;
    }
}
