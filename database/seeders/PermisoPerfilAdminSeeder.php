<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoPerfilAdminSeeder extends Seeder
{
    public function run(): void
    {
        $existe = DB::table('perfil_permiso')
            ->where('perfil_id', 1)   
            ->where('permiso_id', 1)  
            ->exists();

        if (! $existe) {
            DB::table('perfil_permiso')->insert([
                'perfil_id'   => 1,
                'permiso_id'  => 1,

                // PERMISOS CRUD
                'is_read'        => true,
                'is_create'       => true,
                'is_update'  => true,
                'is_delete'    => true,

                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
