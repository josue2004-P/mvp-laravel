<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConfiguracionAnalisis extends Model
{
    protected $table = 'configuracion_analisis';

    protected $fillable = [
        'inicial_estatus_id',
        'usuario_creacion_id',
        'usuario_actualizacion_id'
    ];

    public function estatusInicial(): BelongsTo
    {
        return $this->belongsTo(EstatusAnalisis::class, 'inicial_estatus_id');
    }

    public function reglasPerfiles(): HasMany
    {
        return $this->hasMany(ConfiguracionPerfilEstatus::class, 'configuracion_analisis_id');
    }
}