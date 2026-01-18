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

    public function perfiles(): BelongsToMany
    {
        return $this->belongsToMany(Perfil::class, 'perfil_permiso')
                    ->withPivot(['is_leer', 'is_crear', 'is_actualizar', 'is_eliminar'])
                    ->withTimestamps();
    }
}
