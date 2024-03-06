<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter\CurrencyApi;

use App\Domain\ExchangeRate\Service\ExchangeRateProviderInterface;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use DateTimeImmutable;
use Exception;
use GuzzleHttp\Client;
use Override;
use Scheb\YahooFinanceApi\ApiClientFactory;

/**
 * @psalm-suppress UnusedClass
 */
final readonly class ExchangeRateAPIAdapter implements ExchangeRateProviderInterface
{
    /**
     * @throws Exception
     */
    #[Override] public function fetchRate(
        Currency $sourceCurrency,
        Currency $targetCurrency,
        ?DateTimeImmutable $dateTime = null,
    ): MoneyAmount {
        $client = ApiClientFactory::createApiClient(new Client([]));

        $exchangeRate = $client->getExchangeRate(
            (string)$sourceCurrency,
            (string)$targetCurrency,
        );

        if (!$exchangeRate) {
            throw new Exception('Failed to get quote exception');
        }

        return MoneyAmount::create($exchangeRate->getBid());
    }
}
