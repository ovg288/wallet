<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\BalanceChange\Repository\BalanceChangeRepositoryInterface;
use App\Domain\BalanceChange\Model\BalanceChange as DomainBalanceChange;
use App\Infrastructure\Persistence\Doctrine\Entity\BalanceChange as InfrastructureBalanceChange;
use App\Infrastructure\Persistence\Doctrine\Entity\Wallet;
use Doctrine\ORM\EntityRepository;

final class BalanceChangeRepository extends EntityRepository implements BalanceChangeRepositoryInterface
{
    public function create(DomainBalanceChange $domainBalanceChange, Wallet $wallet): void
    {
        $balanceChange = new InfrastructureBalanceChange();
        $balanceChange->setTransactionType((string)$domainBalanceChange->getTransactionType())
            ->setAmount($domainBalanceChange->getAmount()->getAmount()->amount())
            ->setChangeReason((string)$domainBalanceChange->getChangeReason())
            ->setWallet($wallet)
            ->setTransactionType((string)$domainBalanceChange->getTransactionType())
            ->setCurrency((string)$domainBalanceChange->getAmount()->getCurrency())
            ->setCreatedAt($domainBalanceChange->getCreatedAt())
        ;

        $this->_em->persist($balanceChange);
        $this->_em->flush();
    }
}
