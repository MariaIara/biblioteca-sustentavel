<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@biblioteca.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@biblioteca.com',
                'password' => Hash::make('biblioteca@2024'),
            ]
        );
    }
}
