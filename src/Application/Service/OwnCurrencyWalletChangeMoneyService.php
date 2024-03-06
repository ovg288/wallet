<?php

namespace App\Application\Service;

use App\Domain\ExchangeRate\Service\CurrencyConverterInterface;
use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\MoneyAmount;

class OwnCurrencyWalletChangeMoneyService implements WalletChangeMoneyServiceInterface
{
    public function __construct(
        private CurrencyConverterInterface $currencyConverter,
    ) {
    }

    public function createMoney(Wallet $wallet, Money $changeMoney): Money
    {
        if (!$wallet->getBalance()->getCurrency()->equalsTo($changeMoney->getCurrency())) {
            $amount = $this->currencyConverter->convert(
                Currency::create((string)$changeMoney->getCurrency()),
                $wallet->getBalance()->getCurrency(),
                MoneyAmount::create($changeMoney->getAmount()->amount())
            );

            $money = Money::create(
                $amount,
                $wallet->getBalance()->getCurrency(),
            );
        } else {
            $money = Money::create(
                MoneyAmount::create($changeMoney->getAmount()->amount()),
                Currency::create((string)$changeMoney->getCurrency()),
            );
        }

        return $money;
    }
}
