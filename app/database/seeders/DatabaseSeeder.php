<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Пользователи
        User::factory()->create([
            'name' => 'Администратор',
            'email' => 'admin@excdev-test.loc',
            'password' => Hash::make('HQvv3zzVH6dc8NTc'),
        ]);
    }
}
