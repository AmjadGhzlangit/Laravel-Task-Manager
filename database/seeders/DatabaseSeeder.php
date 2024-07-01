<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Task\TaskSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(TaskSeeder::class);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456789',
        ]);
    }
}
