<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\WalletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\Table(name: "wallet")]
final class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private int $userId;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private string $currency;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private float $balance;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: BalanceChange::class)]
    private Collection $balanceChanges;

    public function __construct()
    {
        $this->balanceChanges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): Wallet
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): Wallet
    {
        $this->currency = $currency;

        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): Wallet
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection<int, BalanceChange>
     */
    public function getBalanceChanges(): Collection
    {
        return $this->balanceChanges;
    }
}
