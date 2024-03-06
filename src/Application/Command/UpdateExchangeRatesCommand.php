<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\DTO\CreateExchangeRatesDto;
use App\Application\UseCase\AddExchangeRateUseCase;
use App\Domain\Wallet\Reference\CurrencyEnum;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @psalm-suppress UnusedClass
 */
final class UpdateExchangeRatesCommand extends Command
{
    public function __construct(
        private readonly AddExchangeRateUseCase $addExchangeRateUseCase,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:update-exchange-rates')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->addExchangeRateUseCase->execute(
            new CreateExchangeRatesDto(
                CurrencyEnum::cases(),
                new DateTimeImmutable('now')
            )
        );

        return Command::SUCCESS;
    }
}
