<?php

namespace App\Features\Auth;

use App\Features\Auth\Dto\Credentials;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login
{
    public const WRONG_EMAIL_MESSAGE = 'Неверный email';
    public const WRONG_PASSWORD_MESSAGE = 'Неверный пароль';
    /**
     * @throws ValidationException
     */
    public function __invoke(Credentials $credentials): array
    {
        $user = User::query()
            ->select('id', 'email', 'password', 'name')
            ->where('email', $credentials->email())
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => [
                    'exists' => self::WRONG_EMAIL_MESSAGE
                ]
            ]);
        }

        if (!Hash::check($credentials->password(), $user->password)) {
            throw ValidationException::withMessages([
                'password' => [
                    'wrong' => self::WRONG_PASSWORD_MESSAGE
                ]
            ]);
        }

        Auth::loginUsingId($user->id, $credentials->getRemember());

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
