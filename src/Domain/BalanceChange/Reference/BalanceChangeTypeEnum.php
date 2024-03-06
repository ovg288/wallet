<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\Reference;

enum BalanceChangeTypeEnum: string
{
    case DEBIT = 'DEBIT';
    case CREDIT = 'CREDIT';
}
