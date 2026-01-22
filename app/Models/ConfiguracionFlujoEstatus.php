<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracionFlujoEstatus extends Model
{
    protected $table = 'configuracion_flujo_estatus_analisis';

    public $incrementing = false;
    protected $primaryKey = ['configuracion_analisis_id', 'estatus_id', 'estatus_siguiente_id'];

    protected $fillable = [
        'configuracion_analisis_id',
        'estatus_id',
        'estatus_siguiente_id',
        'usuario_creacion_id',
        'usuario_actualizacion_id'
    ];

    public function estatusActual(): BelongsTo
    {
        return $this->belongsTo(EstatusAnalisis::class, 'estatus_id');
    }

    public function estatusSiguiente(): BelongsTo
    {
        return $this->belongsTo(EstatusAnalisis::class, 'estatus_siguiente_id');
    }
}