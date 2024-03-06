<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\Exception;

use Exception;

final class InsufficientFundsException extends Exception
{
    protected $code = 1001;
    protected $message = 'Insufficient funds on balance';
}
