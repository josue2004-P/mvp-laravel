<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('checkPerfil')) {

    /**
     * Verifica si el usuario autenticado tiene alguno de los perfiles indicados
     *
     * @param array|string $perfiles
     * @return bool
     */
    function checkPerfil($perfiles): bool
    {
        $user = Auth::user();

        if (!$user || $user->perfiles->isEmpty()) {
            return false;
        }

        // Permitir siempre si es administrador
        if ($user->perfiles->contains('nombre', 'administrador')) {
            return true;
        }

        // Convertir string a array si es necesario
        $perfiles = is_array($perfiles) ? $perfiles : [$perfiles];

        // Verificar si el usuario tiene alguno de los perfiles indicados
        return $user->perfiles->contains(function ($perfil) use ($perfiles) {
            return in_array($perfil->nombre, $perfiles);
        });
    }
}
