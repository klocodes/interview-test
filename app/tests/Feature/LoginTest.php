<?php

namespace Feature;

use App\Features\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testSuccess(): void
    {
        $email = 'test@example.com';
        $password = 'password123';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson('/login', [
            'email' => $email,
            'password' => $password,
            "remember" => false

        ]);

        $response->assertStatus(200);
    }

    public function testWrongEmail(): void
    {
        $email = 'test@example.com';
        $password = 'password123';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson('/login', [
            'email' => "wrong@example.com",
            'password' => $password,
            "remember" => false

        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email' => Login::WRONG_EMAIL_MESSAGE]);
    }

    public function testWrongPassword(): void
    {
        $email = 'test@example.com';
        $password = 'password123';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $response = $this->postJson('/login', [
            'email' => $email,
            'password' => "wrongpassword",
            "remember" => false

        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password' => Login::WRONG_PASSWORD_MESSAGE]);
    }
}
