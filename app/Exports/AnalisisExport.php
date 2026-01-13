<?php

namespace App\Exports;

use App\Models\Analisis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnalisisExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $search;
    protected $doctorId;
    protected $tipoAnalisisId;

    // Recibimos los filtros en el constructor
    public function __construct($search = null, $doctorId = null, $tipoAnalisisId = null)
    {
        $this->search = $search;
        $this->doctorId = $doctorId;
        $this->tipoAnalisisId = $tipoAnalisisId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Analisis::with([
            'cliente', 'doctor', 'tipoAnalisis', 'tipoMetodo', 'tipoMuestra', 'usuarioCreacion'
        ])
        ->whereHas('cliente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
        ->when($this->doctorId, function ($query) {
            $query->where('idDoctor', $this->doctorId);
        })
        ->when($this->tipoAnalisisId, function ($query) {
            $query->where('idTipoAnalisis', $this->tipoAnalisisId);
        })
        ->get();
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