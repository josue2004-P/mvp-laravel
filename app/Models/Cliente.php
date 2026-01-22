<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

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

    public function analisis(): HasMany{return $this->hasMany(Analisis::class, 'cliente_id');}

    public function getNombreCompletoAttribute(): string{return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";}

    public function scopeActivos($query){return $query->where('is_activo', true);}
}