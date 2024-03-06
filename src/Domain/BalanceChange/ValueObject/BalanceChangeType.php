<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\ValueObject;

use App\Domain\BalanceChange\Reference\BalanceChangeTypeEnum;
use Exception;

final readonly class BalanceChangeType
{
    public function __construct(
        private string $changeType,
    ) {
        if (!BalanceChangeTypeEnum::tryFrom($this->changeType)) {
            throw new Exception('Unknown Balance Change type');
        }
    }

    public function __toString(): string
    {
        return $this->changeType;
    }

    public static function create(string $changeType): BalanceChangeType
    {
        return new BalanceChangeType($changeType);
    }
}
