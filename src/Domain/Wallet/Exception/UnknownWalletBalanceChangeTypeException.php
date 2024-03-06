<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Exception;

use Exception;

final class UnknownWalletBalanceChangeTypeException extends Exception
{
    protected $code = 2002;
    protected $message = 'Unknown wallet balance change type';
}
