<?php

namespace App\Features\Balance\Dto;

class ChangeData
{
    private string $userId;
    private float $amount;

    public function __construct(string $userId, float $amount)
    {
        $this->userId = $userId;
        $this->amount = $amount;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
