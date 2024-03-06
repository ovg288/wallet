<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\BalanceChangeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: BalanceChangeRepository::class)]
#[ORM\Table(name: 'balance_change')]
final class BalanceChange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Wallet::class, inversedBy: 'balance_changes')]
    private Wallet $wallet;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private float $amount;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private string $transactionType;

    #[ORM\Column(type: Types::STRING, length: 8)]
    private string $changeReason;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private string $currency;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): BalanceChange
    {
        $this->id = $id;
        return $this;
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): BalanceChange
    {
        $this->wallet = $wallet;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): BalanceChange
    {
        $this->amount = $amount;
        return $this;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function setTransactionType(string $transactionType): BalanceChange
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function getChangeReason(): string
    {
        return $this->changeReason;
    }

    public function setChangeReason(string $changeReason): BalanceChange
    {
        $this->changeReason = $changeReason;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): BalanceChange
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setCurrency(string $currency): BalanceChange
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
