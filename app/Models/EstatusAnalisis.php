<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatusAnalisis extends Model
{
    use HasFactory;

    // Definimos el nombre de la tabla manualmente por el plural en español
    protected $table = 'estatus_analisis';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'color_texto',
        'color_fondo',
        'analisis_abierto',
        'analisis_cerrado',
    ];

    // Casteo de tipos para los campos booleanos
    protected $casts = [
        'analisis_abierto' => 'boolean',
        'analisis_cerrado' => 'boolean',
    ];
}