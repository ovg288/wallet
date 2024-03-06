<?php

namespace App\Domain\Wallet\ValueObject;

final readonly class UserId
{
    public function __construct(
        public int $userId
    ) {
        // todo validate rules
    }

    public static function create(int $userId): UserId
    {
        return new UserId($userId);
    }
}
