<?php

namespace App\Features\Operations\Dto;

class PerformingData
{
    private string $userEmail;
    private string $type;
    private float $amount;
    private string $description;

    public function __construct(string $userEmail, string $type, float $amount, string $description)
    {
        $this->userEmail = $userEmail;
        $this->type = $type;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function userEmail(): string
    {
        return $this->userEmail;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function description(): string
    {
        return $this->description;
    }
}
