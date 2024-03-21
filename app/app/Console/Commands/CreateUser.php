<?php

namespace App\Console\Commands;

use App\Features\Users\Create;
use App\Features\Users\Dto\CreationData;
use App\Models\User;
use DomainException;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Новый пользователь';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = text(
            label: 'Введите имя',
            placeholder: 'Имя',
            required: true,
        );
        $email = text(
            label: 'Введите email',
            placeholder: 'Email',
            required: true,
            validate: fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL) ? null : 'Неверный формат email',
        );
        $password = password(
            label: 'Введите пароль',
            placeholder: 'Пароль',
            required: true,
            validate: fn($password) => Str::length($password) >= User::PASSWORD_MIN_LENGTH ? null : 'Пароль слишком короткий',
            hint: 'Пароль должен быть не менее ' . User::PASSWORD_MIN_LENGTH . ' символов',
        );

        $createUser = new Create();

        try {
            $createUser(new CreationData(
                name: $name,
                email: $email,
                password: $password,
            ));
            $this->info('Пользователь успешно создан');
        } catch (DomainException $e) {
            $this->error($e->getMessage());
        }
    }
}
