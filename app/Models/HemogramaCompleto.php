<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HemogramaCompleto extends Model
{
    use HasFactory;

    protected $table = 'hemograma_completo';

    protected $fillable = [
        'nombre',
        'categoria_hemograma_completo_id',
        'unidad_id',
        'referencia',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaHemogramaCompleto::class, 'categoria_hemograma_completo_id');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad_id');
    }

    public function tiposAnalisis()
    {
        return $this->belongsToMany(TipoAnalisis::class, 'hemograma_completo_tipo_analisis')
                    ->withTimestamps();
    }
    
    public function analisis()
    {
        return $this->belongsToMany(
            \App\Models\Analisis::class,
            'analisis_hemograma',
            'idHemograma',
            'idAnalisis'
        )->withPivot('resultado')
        ->withTimestamps();
    }

}
