<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('checkPermiso')) {

    function checkPermiso(?string $key): bool
    {
        $user = Auth::user();

        if (!$user || $user->perfiles->isEmpty()) {
            return false;
        }

        // Siempre permitir si es administrador
        if ($user->perfiles->contains('nombre', 'administrador')) {
            return true;
        }

        // Si no se envía un permiso específico, asumimos 'is_read'
        $key = $key ?: 'is_read';

        // Si no tiene '.', asumimos que es un módulo y acción = is_read
        if (!str_contains($key, '.')) {
            $modulo = $key;
            $accion = 'is_read';
        } else {
            [$modulo, $accion] = explode('.', $key);
        }

        return $user->perfiles->contains(function ($perfil) use ($modulo, $accion) {
            return $perfil->permisos()
                ->where('nombre', ucfirst($modulo))
                ->wherePivot($accion, true)
                ->exists();
        });
    }
}
