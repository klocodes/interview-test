<?php

declare(strict_types=1);

namespace App\Features\Operations;

enum OperationType: string
{
    case WITHDRAW = 'withdraw';
    case DEPOSIT = 'deposit';
}
