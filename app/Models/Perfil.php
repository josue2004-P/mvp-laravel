<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfil extends Model
{
    protected $table = 'perfiles';

    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'perfil_permiso')
                    ->withPivot(['is_leer', 'is_crear', 'is_actualizar', 'is_eliminar'])
                    ->withTimestamps();
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class);
    }
}