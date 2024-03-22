<?php

namespace App\Features\Balance;

use App\Models\Balance;

class FetchCurrentBalance
{
    public function __invoke(int $user_id): ?Balance
    {
        $balance = Balance::query()
            ->where('user_id', $user_id)
            ->first();

        if (!$balance) {
            $balance = new Balance();
            $balance->user_id = $user_id;
            $balance->amount = 0.00;
        }

        return $balance;
    }
}
