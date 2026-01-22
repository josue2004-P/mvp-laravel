<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisoDefaultSeeder extends Seeder
{
    public function run(): void
    {
        if (!Permiso::where('nombre', 'administrador')->exists()) {
            Permiso::create([
                'nombre' => 'administrador',
                'descripcion' => 'Permiso del sistema',
            ]);
        }
    }
}
