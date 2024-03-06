<?php

namespace App\Domain\ExchangeRate\Service;

use App\Domain\ExchangeRate\Model\ExchangeRate;
use App\Domain\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use App\Domain\Wallet\ValueObject\Currency;

class ExchangeRateProvider
{
    public function __construct(
        private ExchangeRateRepositoryInterface $repository
    ) {
    }

    public function updateExchangeRate(
        Currency $sourceCurrency,
        Currency $targetCurrency
    ): void {
        // Имитация вызова внешнего API для получения курса валют
        $rate = $this->fetchRateFromAPI($sourceCurrency, $targetCurrency);

        $exchangeRate = new ExchangeRate($sourceCurrency, $targetCurrency, $rate, new DateTime());

        $this->repository->save($exchangeRate);
    }

    private function fetchRateFromAPI(string $sourceCurrency, string $targetCurrency): float
    {
        // Здесь должна быть логика вызова внешнего API
        return 0.85; // Возвращаем фиктивный курс для примера
    }
}
