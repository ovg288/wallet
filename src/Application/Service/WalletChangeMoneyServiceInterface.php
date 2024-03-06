<?php

namespace App\Application\Service;

use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\ValueObject\Money;

interface WalletChangeMoneyServiceInterface
{
    public function createMoney(Wallet $wallet, Money $changeMoney): Money;
}
