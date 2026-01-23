<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    use HasFactory;

    protected $table = 'analisis'; 
    
    protected $fillable = [
        'estatus_id', 'cliente_id', 'doctor_id', 'tipo_analisis_id', 
        'tipo_metodo_id', 'tipo_muestra_id', 'usuario_creacion_id', 'nota',
        
    ];

    protected $casts = [
        'fecha_toma' => 'datetime',
    ];

    // Relaciones
    public function cliente() { return $this->belongsTo(Cliente::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
    public function estatus() { return $this->belongsTo(EstatusAnalisis::class, 'estatus_id'); }
    public function tipoAnalisis() { return $this->belongsTo(TipoAnalisis::class, 'tipo_analisis_id'); }
    public function tipoMetodo() { return $this->belongsTo(TipoMetodo::class, 'tipo_metodo_id'); }
    public function tipoMuestra() { return $this->belongsTo(TipoMuestra::class, 'tipo_muestra_id'); }
    public function usuarioCreacion() { return $this->belongsTo(User::class, 'usuario_creacion_id'); }

    public function resultados() { return $this->hasMany(ResultadoAnalisisHemograma::class); }

    public function hemogramas(): BelongsToMany
    {
        return $this->belongsToMany(
            HemogramaCompleto::class,
            'resultado_analisis_hemograma',
            'analisis_id',                  
            'hemograma_completo_id'         
        )
        ->withPivot([
            'resultado', 
            'usuario_creacion_id', 
            'usuario_actualizacion_id'
        ])
        ->withTimestamps();
    }

}
