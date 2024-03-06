<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\CreateExchangeRatesDto;
use App\Domain\ExchangeRate\Model\ExchangeRate;
use App\Domain\ExchangeRate\Repository\ExchangeRateRepositoryInterface;
use App\Domain\ExchangeRate\Service\ExchangeRateProviderInterface;
use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\ValueObject\Currency;

final readonly class AddExchangeRateUseCase
{
    public function __construct(
        private ExchangeRateRepositoryInterface $exchangeRateRepository,
        private ExchangeRateProviderInterface $exchangeRateProvider,
    ) {
    }

    /**
     * @throws UnknownCurrencyException
     */
    public function execute(CreateExchangeRatesDto $dto): void
    {
        foreach ($dto->currencies as $baseCurrency) {
            foreach ($dto->currencies as $counterCurrency) {
                if ($baseCurrency->value !== $counterCurrency->value) {
                    $rate = $this->exchangeRateProvider->fetchRate(
                        Currency::create($baseCurrency->value),
                        Currency::create($counterCurrency->value),
                    );

                    $exchangeRate = ExchangeRate::create(
                        Currency::create($baseCurrency->value),
                        Currency::create($counterCurrency->value),
                        $rate,
                    );
                    $this->exchangeRateRepository->save($exchangeRate);
                }
            }
        }
    }
}
