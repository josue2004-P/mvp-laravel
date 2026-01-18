<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // OBTENER DOCTORES
    public function doctores(): HasMany
    {
        return $this->hasMany(Doctor::class, 'especialidad_id');
    }
}