<?php

namespace Feature;

use App\Features\Users\Create;
use App\Features\Users\Dto\CreationData;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccess(): void
    {
        $dto = new CreationData('test', 'test@example.com', 'password123');

        $createUser = new Create();
        $createUser($dto);

        $this->assertDatabaseHas('users', [
            'name' => $dto->name(),
            'email' => $dto->email(),
        ]);
    }

    public function testUserExists(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $dto = new CreationData('test', 'test@example.com', 'password123');

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage(Create::USER_EXISTS_MESSAGE);

        $createUser = new Create();
        $createUser($dto);
    }
}
