<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnalisis extends Model
{
    use HasFactory;

    protected $table = 'tipo_analisis';

    protected $fillable = ['nombre','descripcion'];

    public function hemogramas()
    {
        return $this->belongsToMany(HemogramaCompleto::class, 'hemograma_completo_tipo_analisis');
    }
}
