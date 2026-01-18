<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracionPerfilEstatus extends Model
{
    protected $table = 'configuracion_perfil_estatus_analisis';

    public $incrementing = false;
    protected $primaryKey = ['configuracion_analisis_id', 'perfil_id', 'estatus_id'];
    protected $keyType = 'string';

    protected $fillable = [
        'configuracion_analisis_id',
        'perfil_id',
        'estatus_id',
        'modificar',
        'automatico',
        'usuario_creacion_id',
        'usuario_actualizacion_id'
    ];

    protected $casts = [
        'modificar' => 'boolean',
        'automatico' => 'boolean',
    ];

    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class);
    }

    public function estatus(): BelongsTo
    {
        return $this->belongsTo(EstatusAnalisis::class);
    }
}