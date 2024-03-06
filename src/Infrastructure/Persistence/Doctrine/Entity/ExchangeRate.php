<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\ExchangeRateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: ExchangeRateRepository::class)]
#[Index(columns: ["created_at", "base_currency", "counter_currency"])]
class ExchangeRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private string $baseCurrency;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private string $counterCurrency;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2)]
    private float $rate;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    public DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function setBaseWallet(string $baseCurrency): ExchangeRate
    {
        $this->baseCurrency = $baseCurrency;
        return $this;
    }

    public function getCounterWallet(): string
    {
        return $this->counterCurrency;
    }

    public function setCounterWallet(string $counterCurrency): ExchangeRate
    {
        $this->counterCurrency = $counterCurrency;
        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): ExchangeRate
    {
        $this->rate = $rate;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): ExchangeRate
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
