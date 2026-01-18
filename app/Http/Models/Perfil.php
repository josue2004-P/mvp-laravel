<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    protected $fillable = ['nombre', 'descripcion'];

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'perfil_permiso', 'perfil_id', 'permiso_id')
                    ->withPivot(['is_leer', 'is_crear', 'is_actualizar', 'is_eliminar'])
                    ->withTimestamps();
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'perfil_user', 'perfil_id', 'user_id')
                    ->withTimestamps();
    }
}