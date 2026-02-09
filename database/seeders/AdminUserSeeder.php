<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'usuario' => 'JOSUE',
                'name' => 'Josue',
                'apellido_paterno' => 'Perez',
                'apellido_materno' => 'Eulogio',
                'password' => Hash::make('JOSUE'), 
            ]
        );
    }
}
