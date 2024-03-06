<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\ExchangeRate\Model\ExchangeRate;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use App\Infrastructure\Persistence\Doctrine\Entity\ExchangeRate as InfrastructureExchangeRate;
use App\Domain\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Override;

class ExchangeRateRepository extends EntityRepository implements ExchangeRateRepositoryInterface
{
    #[Override] public function findRate(
        Currency $sourceCurrency,
        Currency $targetCurrency
    ): ?MoneyAmount {
        $rate = $this->_em->getRepository(InfrastructureExchangeRate::class)
            ->findOneBy([
                'baseCurrency' => (string)$sourceCurrency,
                'counterCurrency' => (string)$targetCurrency,
            ], ['createdAt' => 'desc']);

        $result = null;
        if ($rate) {
            $result = MoneyAmount::create($rate->getRate());
        }

        return $result;
    }

    #[Override] public function save(ExchangeRate $exchangeRate): void
    {
        $infrastructureExchangeRate = new InfrastructureExchangeRate();
        $infrastructureExchangeRate->setBaseWallet((string)$exchangeRate->baseCurrency)
            ->setCounterWallet((string)$exchangeRate->targetCurrency)
            ->setRate($exchangeRate->rate->amount())
            ->setCreatedAt($exchangeRate->date);

        $this->_em->persist($infrastructureExchangeRate);
        $this->_em->flush();
    }
}
