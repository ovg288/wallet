<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Service\WalletService;
use App\Domain\Wallet\Exception\NegativeAmountException;
use App\Domain\Wallet\Exception\UnknownCurrencyException;
use App\Domain\Wallet\Model\Wallet;
use App\Domain\Wallet\Reference\CurrencyEnum;
use App\Domain\Wallet\ValueObject\Currency;
use App\Domain\Wallet\ValueObject\Money;
use App\Domain\Wallet\ValueObject\MoneyAmount;
use App\Domain\Wallet\ValueObject\UserId;
use App\Domain\Wallet\ValueObject\WalletId;
use Exception;
use Random\RandomException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @psalm-suppress UnusedClass
 */
final class GenerateDataCommand extends Command
{
    public function __construct(
        private readonly WalletService $walletService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:generate-initial-data')
            ->setDescription('Generate initial wallets and transactions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->generateWallets();
        } catch (NegativeAmountException | UnknownCurrencyException | RandomException | Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('Test data generated successfully.');
        return Command::SUCCESS;
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NegativeAmountException
     * @throws RandomException
     */
    private function generateWallets(): void
    {
        // "refactor get last user id and using it as $idx
        for ($idx = 0; $idx <= 1000; $idx++) {
            $currencyIdx = array_rand(CurrencyEnum::cases());
            $currency = new Currency(CurrencyEnum::cases()[$currencyIdx]->value);

            $money = new Money(
                MoneyAmount::create(random_int(0, 100000) / 100),
                $currency
            );
            $wallet = new Wallet(
                WalletId::create($idx),
                UserId::create($idx),
                $money
            );

            $this->walletService->createWallet($wallet);
        }
    }
}
