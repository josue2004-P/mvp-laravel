<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfil extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function permisos()
    {
        return $this->belongsToMany(
            Permiso::class,
            'perfil_permiso',   
            'perfil_id',        
            'permiso_id'       
        )
        ->withPivot(['leer', 'crear', 'actualizar', 'eliminar'])
        ->withTimestamps();
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class);
    }
}