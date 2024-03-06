<?php

namespace App\Domain\BalanceChange\Reference;

enum BalanceChangeReasonEnum: string
{
    case STOCK = 'STOCK';
    case REFUND = 'REFUND';
}
