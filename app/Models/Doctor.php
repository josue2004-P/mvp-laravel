<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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


    public function especialidades(){return $this->belongsToMany(Especialidad::class, 'doctor_especialidad');}

    public function analisis(): HasMany{return $this->hasMany(Analisis::class, 'doctor_id');}

    public function getNombreCompletoAttribute(): string{return "Dr(a). {$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";}
}