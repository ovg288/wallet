<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Exception;

use Exception;

final class NegativeAmountException extends Exception
{
    protected $code = 2000;
    protected $message = "NegativeAmountException";
}
