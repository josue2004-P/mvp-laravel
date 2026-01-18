<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function perfiles(): BelongsToMany
    {
        return $this->belongsToMany(Perfil::class, 'perfil_permiso', 'permiso_id', 'perfil_id')
                    ->withPivot(['is_leer', 'is_crear', 'is_actualizar', 'is_eliminar'])
                    ->withTimestamps();
    }
}