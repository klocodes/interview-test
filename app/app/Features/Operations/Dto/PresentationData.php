<?php

namespace App\Features\Operations\Dto;

use App\Features\Operations\OperationType;
use Exception;

class PresentationData
{
    const WITHDRAW_LABEL = "Списание";
    const DEPOSIT_LABEL = "Начисление";

    public string $type;

    public float $amount;

    public string $description;

    public string $date;

    /**
     * @throws Exception
     */
    public function __construct(OperationType $type, float $amount, string $description, string $date)
    {
        match ($type) {
            OperationType::DEPOSIT => $this->type = self::DEPOSIT_LABEL,
            OperationType::WITHDRAW => $this->type = self::WITHDRAW_LABEL,
        };

        $this->amount = $amount;
        $this->description = $description;
        $this->date = $date;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
        ];
    }
}
