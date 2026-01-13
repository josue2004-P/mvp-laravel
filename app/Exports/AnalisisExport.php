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
    protected $tipoMuestraId;
    protected $tipoMetodoId;
    protected $perPage;

    // Actualizamos el constructor para recibir todos los parámetros
    public function __construct(
        $search = null, 
        $doctorId = null, 
        $tipoAnalisisId = null, 
        $tipoMuestraId = null, 
        $tipoMetodoId = null, 
        $perPage = 10
    ) {
        $this->search = $search;
        $this->doctorId = $doctorId;
        $this->tipoAnalisisId = $tipoAnalisisId;
        $this->tipoMuestraId = $tipoMuestraId;
        $this->tipoMetodoId = $tipoMetodoId;
        $this->perPage = $perPage;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Analisis::with([
            'cliente', 'doctor', 'tipoAnalisis', 'tipoMetodo', 'tipoMuestra', 'usuarioCreacion'
        ])
        ->where(function($q) {
            if ($this->search) {
                $q->whereHas('cliente', function ($query) {
                    $query->where('nombre', 'like', '%' . $this->search . '%');
                })->orWhere('id', 'like', '%' . $this->search . '%');
            }
        })
        ->when($this->doctorId, fn($q) => $q->where('idDoctor', $this->doctorId))
        ->when($this->tipoAnalisisId, fn($q) => $q->where('idTipoAnalisis', $this->tipoAnalisisId))
        ->when($this->tipoMuestraId, fn($q) => $q->where('idTipoMuestra', $this->tipoMuestraId))
        ->when($this->tipoMetodoId, fn($q) => $q->where('idTipoMetodo', $this->tipoMetodoId))
        ->latest()
        ->limit($this->perPage) // Aplicamos el límite dinámico
        ->get();
    }

    /**
    * Encabezados de la tabla
    */
    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Doctor',
            'Análisis',
            'Método',
            'Muestra',
            'Usuario (Creación)',
            'Nota',
            'Fecha de Registro',
        ];
    }

    /**
    * Mapeo de columnas
    */
    public function map($analisis): array
    {
        return [
            $analisis->id,
            $analisis->cliente->nombre ?? 'N/A',
            $analisis->doctor->nombre ?? 'N/A',
            $analisis->tipoAnalisis->nombre ?? 'N/A',
            $analisis->tipoMetodo->nombre ?? 'N/A',
            $analisis->tipoMuestra->nombre ?? 'N/A',
            $analisis->usuarioCreacion->name ?? 'N/A',
            $analisis->nota ?: '-',
            $analisis->created_at->format('d/m/Y H:i'),
        ];
    }
}