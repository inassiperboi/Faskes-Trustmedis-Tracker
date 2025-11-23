<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'admin@trustmedis.com'],
            [
                'name' => 'admin',
                'password' => 'admin1234',
                'role' => 'admin',
                'jabatan' => 'administrator',
            ]
        );

        // Test User creation has been removed due to column not found error
    }
}
