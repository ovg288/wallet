<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\Model;

use App\Domain\BalanceChange\ValueObject\BalanceChangeReason;
use App\Domain\BalanceChange\ValueObject\BalanceChangeType;
use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\ValueObject\Money;
use DateTimeImmutable;

final class BalanceChange
{
    private ?int $id = null;

    public function __construct(
        private Wallet $wallet,
        private Money $amount,
        private BalanceChangeType $balanceChangeType,
        private BalanceChangeReason $changeReason,
        private DateTimeImmutable $createdAt,
    ) {
    }

    public static function create(
        Wallet $wallet,
        Money $amount,
        BalanceChangeType $balanceChangeType,
        BalanceChangeReason $changeReason,
        ?DateTimeImmutable $createdAt = null,
    ): BalanceChange {
        if ($createdAt === null) {
            $createdAt = new DateTimeImmutable('now');
        }

        return new BalanceChange(
            $wallet,
            $amount,
            $balanceChangeType,
            $changeReason,
            $createdAt
        );
    }

    public function getTransactionType(): BalanceChangeType
    {
        return $this->balanceChangeType;
    }

    public function setTransactionType(
        BalanceChangeType $balanceChangeType
    ): void {
        $this->balanceChangeType = $balanceChangeType;
    }

    public function getChangeReason(): BalanceChangeReason
    {
        return $this->changeReason;
    }

    public function setChangeReason(
        BalanceChangeReason $changeReason
    ): void {
        $this->changeReason = $changeReason;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setWallet(
        Wallet $wallet
    ): BalanceChange {
        $this->wallet = $wallet;

        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function setAmount(
        Money $transactionAmount
    ): BalanceChange {
        $this->amount = $transactionAmount;
        return $this;
    }
}
