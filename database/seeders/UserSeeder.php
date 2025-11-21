<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus user Inas jika sudah ada (optional)
        User::where('email', 'inas@trustmedis.com')->delete();

        // Buat user Inas
        User::create([
            'name' => 'Inas',
            'email' => 'inas@trustmedis.com',
            'password' => Hash::make('inas1234'),
            'role' => 'user',
            'jabatan' => 'magang'
        ]);

        $this->command->info('User Inas created successfully!');
        $this->command->info('Email: inas@trustmedis.com');
        $this->command->info('Password: inas1234');
        $this->command->info('Role: user');
        $this->command->info('Jabatan: magang');
    }
}