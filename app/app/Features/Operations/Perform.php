<?php

namespace App\Features\Operations;

use App\Features\Balance\Dto\ChangeData;
use App\Features\Operations\Dto\PerformingData;
use App\Jobs\ChangeBalanceJob;
use App\Models\Operation;
use App\Models\User;
use DomainException;

class Perform
{
    public const USER_NOT_FOUND_MESSAGE = 'Пользователь c таким email не найден';
    public const TOO_SMALL_AMOUNT_MESSAGE = 'Сумма операции должна быть больше нуля';
    public const UNKNOWN_OPERATION_TYPE_MESSAGE = 'Неизвестный тип операции';

    public function __invoke(PerformingData $data): void
    {
        $user = User::query()
            ->select('id')
            ->where('email', $data->userEmail())
            ->first();
        if (!$user) {
            throw new DomainException(self::USER_NOT_FOUND_MESSAGE);
        }

        if ($data->amount() <= 0) {
            throw new DomainException(self::TOO_SMALL_AMOUNT_MESSAGE);
        }

        try {
            $type = OperationType::from($data->type());
        } catch (\Error $e) {
            throw new DomainException(self::UNKNOWN_OPERATION_TYPE_MESSAGE);
        }
        match ($type) {
            OperationType::WITHDRAW => $newBalanceAmount = $data->amount() * -1,
            OperationType::DEPOSIT => $newBalanceAmount = $data->amount(),
        };

        Operation::query()->create([
            'user_id' => $user->id,
            'type' => $type->value,
            'amount' => $data->amount(),
            'description' => $data->description(),
        ]);

        $changeBalanceData = new ChangeData(
            userId: $user->id,
            amount: $newBalanceAmount,
        );

        // В идеале, здесь нужно генерировать событие, а не диспатчить задачу изменения баланса напрямую
        ChangeBalanceJob::dispatch($changeBalanceData);
    }
}
