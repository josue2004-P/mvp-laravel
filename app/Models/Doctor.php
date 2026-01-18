<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctores';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'cedula_profesional',
        'especialidad_id',
        'email',
        'telefono',
        'is_activo',
    ];

    protected $casts = [
        'is_activo' => 'boolean',
    ];

    // OBTENER ESPECIALIDADES
    public function especialidad(): BelongsTo
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }

    // OBTENER NOMBRE COMPLETO
    public function getNombreCompletoAttribute(): string
    {
        return "Dr. {$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

}
