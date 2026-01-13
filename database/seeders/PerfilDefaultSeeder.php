<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perfil;

class PerfilDefaultSeeder extends Seeder
{
    public function run(): void
    {
        if (!Perfil::where('nombre', 'administrador')->exists()) {
            Perfil::create([
                'nombre' => 'administrador',
                'descripcion' => 'Perfil con todos los permisos del sistema',
            ]);
        }
    }
}
