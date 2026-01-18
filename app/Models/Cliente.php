<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'edad',
        'fecha_nacimiento',
        'sexo',
        'calle',
        'no_exterior',
        'no_interior',
        'colonia',
        'codigo_postal',
        'ciudad',
        'estado',
        'referencia',
        'is_activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'is_activo' => 'boolean',
        'edad' => 'integer',
    ];

    // OBTENER NOMBRE COMPLETO
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }


}
