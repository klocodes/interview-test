<?php

namespace App\Features\Balance;

use App\Features\Balance\Dto\ChangeData;
use App\Models\Balance;
use App\Models\User;
use DomainException;

class Change
{
    public const USER_NOT_FOUND_MESSAGE = 'Пользователь c таким id не найден';
    public const NEGATIVE_BALANCE_MESSAGE = 'Баланс не может быть отрицательным';

    public function __invoke(ChangeData $data): void
    {
        $userExists = User::query()
            ->where('id', $data->userId())
            ->exists();

        if (!$userExists) {
            throw new DomainException(self::USER_NOT_FOUND_MESSAGE);
        }

        $balance = Balance::query()
            ->select('id', 'amount')
            ->find($data->userId());

        $amount = 0;

        if ($balance) {
            $amount = $balance->amount;
        }

        $amount += $data->amount();

        if ($amount < 0) {
            throw new DomainException(self::NEGATIVE_BALANCE_MESSAGE);
        }

        if ($balance) {
            $balance->update(['amount' => $amount]);
        } else {
            Balance::query()->create([
                'user_id' => $data->userId(),
                'amount' => $data->amount(),
            ]);
        }
    }
}
