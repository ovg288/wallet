<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\Repository;

use App\Domain\BalanceChange\Model\BalanceChange;
use App\Infrastructure\Persistence\Doctrine\Entity\Wallet;

interface BalanceChangeRepositoryInterface
{
    public function create(BalanceChange $domainBalanceChange, Wallet $wallet): void;
}
