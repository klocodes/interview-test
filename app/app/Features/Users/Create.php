<?php

declare(strict_types=1);

namespace App\Features\Users;

use App\Features\Users\Dto\CreationData;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Create
{
    public const TOO_SHORT_PASSWORD_MESSAGE = 'Пароль слишком короткий';
    public const USER_EXISTS_MESSAGE = 'Пользователь с таким email уже существует';

    public function __invoke(CreationData $data): void
    {
        $exists = User::query()->where('email', $data->email())->exists();

        if (Str::length($data->password()) < User::PASSWORD_MIN_LENGTH) {
            throw new DomainException(self::TOO_SHORT_PASSWORD_MESSAGE);
        }

        if ($exists) {
            throw new DomainException(self::USER_EXISTS_MESSAGE);
        }

        User::query()->create([
            'name' => $data->name(),
            'email' => $data->email(),
            'password' => Hash::make($data->password()),
        ]);
    }
}
