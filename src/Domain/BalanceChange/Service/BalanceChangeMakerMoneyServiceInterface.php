<?php

namespace App\Domain\BalanceChange\Service;

use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\ValueObject\Money;

interface BalanceChangeMakerMoneyServiceInterface
{
    public function createMoney(
        Wallet $wallet,
        Money $balanceChangeMoney
    ): Money;
}
