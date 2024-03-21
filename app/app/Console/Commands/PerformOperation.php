<?php

namespace App\Console\Commands;

use App\Features\Operations\Dto\PerformingData;
use App\Features\Operations\Perform;
use App\Models\User;
use DomainException;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class PerformOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:perform-operation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Провести операцию';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Плохая практика использовать Eloquent в команде
        // Сделано для удобства примера и простоты проведения операций
        $usersEmails = User::query()
            ->select('email')
            ->pluck('email');

        if ($usersEmails->isEmpty()) {
            $this->error('Сначала создайте пользователя');

            return;
        }

        $usersEmails = $usersEmails->toArray();

        $type = select(
            label: 'Введите тип операции',
            options: ['withdraw', 'deposit'],
            required: true,
        );
        $userEmail = select(
            label: 'Выберите пользователя',
            options: $usersEmails,
            required: true,
        );
        $amount = text(
            label: 'Введите сумму',
            placeholder: 'Сумма',
            required: true,
        );
        $description = text(
            label: 'Введите описание',
            placeholder: 'Описание',
            required: true,
        );

        $dto = new PerformingData(
            userEmail: $userEmail,
            type: $type,
            amount: $amount,
            description: $description,
        );

        try {
            $performOperation = new Perform();
            $performOperation($dto);
        } catch (DomainException $e) {
            $this->error($e->getMessage());
        }
    }
}
