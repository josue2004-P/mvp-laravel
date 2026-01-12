<?php

namespace App\Exports;

use App\Models\Analisis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalisisExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Usamos Eager Loading (with) para que la exportación sea rápida 
        // y no haga cientos de consultas a la base de datos.
        return Analisis::with([
            'cliente', 
            'doctor', 
            'tipoAnalisis', 
            'tipoMetodo', 
            'tipoMuestra', 
            'usuarioCreacion'
        ])->get();
    }

    /**
    * Encabezados tal cual se ven en tu imagen
    */
    public function headings(): array
    {
        return [
            'Id',
            'Cliente',
            'Doctor',
            'Analisis',
            'Método',
            'Muestra',
            'Usuario',
            'Nota',
        ];
    }

    /**
    * Mapeo de datos usando las relaciones de tu modelo
    * @var Analisis $analisis
    */
    public function map($analisis): array
    {
        return [
            $analisis->id,
            $analisis->cliente->nombre ?? 'N/A', // Asumiendo que el campo es 'nombre'
            $analisis->doctor->nombre ?? 'N/A',
            $analisis->tipoAnalisis->nombre ?? 'N/A', // O el campo que uses para el tipo
            $analisis->tipoMetodo->nombre ?? 'N/A',
            $analisis->tipoMuestra->nombre ?? 'N/A',
            $analisis->usuarioCreacion->name ?? 'N/A', // El modelo User suele usar 'name'
            $analisis->nota,
        ];
    }
}