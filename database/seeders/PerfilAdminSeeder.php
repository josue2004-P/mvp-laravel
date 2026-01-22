<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilAdminSeeder extends Seeder
{
    public function run(): void
    {
        $existe = DB::table('perfil_user')
            ->where('user_id', 1)
            ->where('perfil_id', 1)
            ->exists();

        if (!$existe) {
            DB::table('perfil_user')->insert([
                'user_id' => 1,
                'perfil_id' => 1,
            ]);
        }
    }
}
