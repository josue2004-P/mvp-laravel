<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PerfilDefaultSeeder::class,
            PermisoDefaultSeeder::class,
            PerfilAdminSeeder::class,
            PermisoPerfilAdminSeeder::class,
        ]);
    }
}
