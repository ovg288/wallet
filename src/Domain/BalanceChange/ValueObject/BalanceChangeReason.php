<?php

declare(strict_types=1);

namespace App\Domain\BalanceChange\ValueObject;

use App\Domain\BalanceChange\Reference\BalanceChangeReasonEnum;
use Exception;

final readonly class BalanceChangeReason
{
    public function __construct(
        private string $changeType,
    ) {
        if (!BalanceChangeReasonEnum::tryFrom($this->changeType)) {
            throw new Exception('Unknown Balance Change reason');
        }
    }

    public function __toString(): string
    {
        return $this->changeType;
    }

    public static function create(string $changeType): BalanceChangeReason
    {
        return new BalanceChangeReason($changeType);
    }
}
