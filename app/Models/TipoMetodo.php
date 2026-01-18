<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMetodo extends Model
{
    use HasFactory;

    protected $table = 'tipo_metodos';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

}
