<?php

namespace Tests\Feature;

use App\Features\Balance\Change;
use App\Features\Balance\Dto\ChangeData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChangeBalanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $user = User::factory()->create();

        $dto = new ChangeData(
            userId: $user->id,
            amount: 100,
        );

        $changeBalance = new Change();
        $changeBalance($dto);

        $this->assertDatabaseHas('balances', [
            'user_id' => $user->id,
            'amount' => 100,
        ]);
    }

    public function testUserNotFound(): void
    {
        $this->expectExceptionMessage('Пользователь c таким email не найден');

        $dto = new ChangeData(
            userId: 0,
            amount: 100,
        );

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Пользователь c таким id не найден');

        $changeBalance = new Change();
        $changeBalance($dto);
    }

    public function testNegativeBalance(): void
    {
        $this->expectExceptionMessage('Баланс не может быть отрицательным');

        $user = User::factory()->create();

        $dto = new ChangeData(
            userId: $user->id,
            amount: -100,
        );

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Баланс не может быть отрицательным');

        $changeBalance = new Change();
        $changeBalance($dto);
    }
}
