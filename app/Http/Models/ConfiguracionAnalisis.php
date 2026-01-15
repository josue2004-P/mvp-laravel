<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionAnalisis extends Model
{
    protected $table = 'configuracion_analisis';

    public $timestamps = false;

    protected $fillable = [
        'inicialEstatusId',
        'usuarioCreacionEliminarPartidas',
        'usuarioIdCreacion',
        'usuarioIdActualizacion',
        'fechaCreacion',
        'fechaActualizacion'
    ];

    // Relación con el estatus inicial
    public function estatusInicial()
    {
        return $this->belongsTo(EstatusAnalisis::class, 'inicialEstatusId');
    }
}