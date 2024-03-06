<?php

declare(strict_types=1);

namespace App\Domain\ExchangeRate\Service;

use App\Domain\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use Exception;

final readonly class CurrencyConverter implements CurrencyConverterInterface
{
    public function __construct(
        private ExchangeRateRepositoryInterface $exchangeRateRepository,
        private ExchangeRateProviderInterface $exchangeRateProvider,
    ) {
    }

    /**
     * @throws NegativeAmountException
     * @throws Exception
     */
    public function convert(
        Currency $sourceCurrency,
        Currency $targetCurrency,
        MoneyAmount $amount,
    ): MoneyAmount {
        $rate = $this->exchangeRateRepository->findRate(
            $sourceCurrency,
            $targetCurrency
        );

        if ($rate === null) {
            $rate = $this->exchangeRateProvider->fetchRate(
                $sourceCurrency,
                $targetCurrency,
            );
        }

        if ($rate === null) {
            throw new Exception("Exchange rate not found");
        }

        return $amount->multiply($rate->amount());
    }
}
