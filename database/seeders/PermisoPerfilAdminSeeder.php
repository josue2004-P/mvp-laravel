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
                'leer'        => true,
                'crear'       => true,
                'actualizar'  => true,
                'eliminar'    => true,

                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
