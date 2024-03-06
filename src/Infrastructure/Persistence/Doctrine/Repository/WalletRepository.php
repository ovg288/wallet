<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\Repository\WalletRepositoryInterface;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use App\Domain\Wallet\ValueObject\UserId;
use App\Domain\Wallet\ValueObject\WalletId;
use App\Infrastructure\Persistence\Doctrine\Entity\Wallet as WalletEntity;
use Doctrine\ORM\EntityRepository;
use Exception;

final class WalletRepository extends EntityRepository implements WalletRepositoryInterface
{
    /**
     * @param Wallet $wallet
     *
     * @return void
     */
    public function save(Wallet $wallet): void
    {
        $walletEntity = new WalletEntity();
        $walletEntity->setUserId($wallet->getUserId()->userId);
        $walletEntity->setCurrency((string)$wallet->getBalance()->getCurrency());
        $walletEntity->setBalance($wallet->getBalance()->getAmount()->amount());

        $this->_em->persist($walletEntity);
        $this->_em->flush();
    }

    public function setBalance(Wallet $wallet): WalletEntity
    {
        $walletEntity = $this->_em
            ->getRepository(WalletEntity::class)
            ->find($wallet->getId());

        if ($walletEntity === null) {
            throw new Exception('Wallet not found exception');
        }

        $walletEntity->setBalance($wallet->getBalance()->getAmount()->amount());

        $this->_em->flush();

        return $walletEntity;
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NegativeAmountException
     * @throws Exception
     */
    public function findOneById(
        WalletId $walletId,
    ): ?Wallet {
        $walletEntity = $this->_em
            ->getRepository(WalletEntity::class)
            ->find($walletId->walletId);

        if (!$walletEntity) {
            return null;
        } else {
            $money = Money::create(
                MoneyAmount::create($walletEntity->getBalance()),
                Currency::create($walletEntity->getCurrency()),
            );

            return new Wallet(
                WalletId::create($walletEntity->getId()),
                UserId::create($walletEntity->getUserId()),
                $money,
            );
        }
    }
}
