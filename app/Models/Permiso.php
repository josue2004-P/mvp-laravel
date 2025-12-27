<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function perfiles()
    {
        return $this->belongsToMany(
            Perfil::class,
            'perfil_permiso',
            'permiso_id',
            'perfil_id'
        )
        ->withPivot(['leer', 'crear', 'actualizar', 'eliminar'])
        ->withTimestamps();
    }
}
