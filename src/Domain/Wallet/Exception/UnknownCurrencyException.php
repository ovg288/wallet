<?php

namespace App\Domain\Wallet\Exception;

use Exception;

class UnknownCurrencyException extends Exception
{
    protected $code = 3000;
    protected $message = "Unknown currency exception";
}
