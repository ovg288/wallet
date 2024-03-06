<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Model;

use App\Domain\BalanceChange\Reference\BalanceChangeTypeEnum;
use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\Exception\UnknownWalletBalanceChangeTypeException;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\UserId;
use App\Domain\Wallet\ValueObject\WalletId;

final class Wallet
{
    public function __construct(
        private readonly WalletId $id,
        private readonly UserId $userId,
        private Money $balance,
    ) {
        // todo validation rules
    }

    public function getId(): int
    {
        return $this->id->walletId;
    }

    public function getBalance(): Money
    {
        return $this->balance;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @throws NegativeAmountException
     * @throws UnknownWalletBalanceChangeTypeException
     */
    public function changeMoney(string $type, Money $money): self
    {
        switch ($type) {
            case BalanceChangeTypeEnum::DEBIT->value:
                $this->addFunds($money);
                break;
            case BalanceChangeTypeEnum::CREDIT->value:
                $this->reduceFunds($money);
                break;
            default:
                throw new UnknownWalletBalanceChangeTypeException();
        }

        return $this;
    }

    /**
     * @throws NegativeAmountException
     */
    private function addFunds(Money $money): void
    {
        $this->balance = $this->balance->add($money);
    }

    /**
     * @throws NegativeAmountException
     */
    private function reduceFunds(Money $money): void
    {
        $this->balance = $this->balance->subtract($money);
    }

    public static function create(
        WalletId $walletId,
        UserId $userId,
        Money $money,
    ): Wallet {
        return new Wallet(
            $walletId,
            $userId,
            $money,
        );
    }
}
