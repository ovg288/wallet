<?php

namespace App\Application\Exception;

use Exception;

class WalletNotFoundException extends Exception
{
    protected $code = 4000;
    protected $message = 'Wallet not found';
}
