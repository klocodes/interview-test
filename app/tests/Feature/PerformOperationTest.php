<?php

namespace Tests\Feature;

use App\Features\Operations\Dto\PerformingData;
use App\Features\Operations\Perform;
use App\Models\User;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformOperationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $user = User::factory()->create();

        $dto = new PerformingData(
            userEmail: $user->email,
            type: 'deposit',
            amount: 100,
            description: 'Test deposit',
        );

        $performOperation = new Perform();
        $performOperation($dto);

        $this->assertDatabaseHas('operations', [
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => 100,
            'description' => 'Test deposit',
        ]);
    }

    public function testUserNotFound(): void
    {
        $this->expectExceptionMessage('Пользователь c таким email не найден');

        $dto = new PerformingData(
            userEmail: '',
            type: 'deposit',
            amount: 100,
            description: 'Test deposit',
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Пользователь c таким email не найден');

        $performOperation = new Perform();
        $performOperation($dto);
    }

    public function testTooSmallAmount(): void
    {
        $this->expectExceptionMessage('Сумма операции должна быть больше нуля');

        $user = User::factory()->create();

        $dto = new PerformingData(
            userEmail: $user->email,
            type: 'deposit',
            amount: 0,
            description: 'Test deposit',
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Сумма операции должна быть больше нуля');

        $performOperation = new Perform();
        $performOperation($dto);
    }

    public function testUnknownOperationType(): void
    {
        $user = User::factory()->create();

        $dto = new PerformingData(
            userEmail: $user->email,
            type: "unknown",
            amount: 100,
            description: 'Test deposit',
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Неизвестный тип операции');

        $performOperation = new Perform();
        $performOperation($dto);
    }
}
