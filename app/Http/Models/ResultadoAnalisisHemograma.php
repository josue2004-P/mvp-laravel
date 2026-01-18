<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultadoAnalisisHemograma extends Model
{
    protected $table = 'resultado_analisis_hemograma';

    protected $fillable = [
        'analisis_id',
        'hemograma_completo_id',
        'resultado',
        'usuario_creacion_id',
        'usuario_actualizacion_id'
    ];

    public function analisis(): BelongsTo
    {
        return $this->belongsTo(Analisis::class);
    }

    public function parametro(): BelongsTo
    {
        return $this->belongsTo(HemogramaCompleto::class, 'hemograma_completo_id');
    }
}