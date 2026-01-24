<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HemogramaCompleto extends Model
{
    use HasFactory;

    protected $table = 'hemograma_completo';

    protected $fillable = [
        'nombre',
        'categoria_hemograma_completo_id',
        'unidad_id',
        'tipo_valor',     
        'referencia',
        'rango_ideal',     
        'rango_moderado', 
        'rango_alto',      
    ];

    public function categoria(): BelongsTo{return $this->belongsTo(CategoriaHemogramaCompleto::class, 'categoria_hemograma_completo_id');}

    public function unidad(): BelongsTo{return $this->belongsTo(Unidad::class, 'unidad_id');}

    public function resultados(): HasMany{return $this->hasMany(ResultadoAnalisisHemograma::class, 'hemograma_completo_id');}

    public function getNombreConUnidadAttribute(): string{return "{$this->nombre} ({$this->unidad->nombre})";}

    public function tieneRangosEscalonados()
    {
        return !empty($this->rango_ideal) || !empty($this->rango_moderado) || !empty($this->rango_alto);
    }

    public function getTipoValorFormateadoAttribute()
    {
        if (!$this->tipo_valor) return null;
        return $this->tipo_valor === 'diferencial' ? 'Diferencial (%)' : 'Absolutos (mm³)';
    }
}