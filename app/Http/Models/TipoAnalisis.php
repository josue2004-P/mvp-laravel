<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoAnalisis extends Model
{
    use HasFactory;

    protected $table = 'tipo_analisis';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function analisis(): HasMany{return $this->hasMany(Analisis::class, 'tipo_analisis_id');}

    public function parametrosHemograma(): BelongsToMany
    {
        return $this->belongsToMany(
            HemogramaCompleto::class, 
            'hemograma_completo_tipo_analisis', 
            'tipo_analisis_id', 
            'hemograma_completo_id'
        )->withTimestamps();
    }
}