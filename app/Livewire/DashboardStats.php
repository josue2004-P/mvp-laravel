<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Doctor;
use App\Models\Analisis;
use App\Models\TipoAnalisis;
use Illuminate\Support\Facades\DB;

class DashboardStats extends Component
{
    public $clientes;
    public $doctores;
    public $analisis;
    public $tiposAnalisis;

    public $clientesPorMes = [];

    public function mount()
    {
        // Totales
        $this->clientes = Cliente::count();
        $this->doctores = Doctor::count();
        $this->analisis = Analisis::count();
        $this->tiposAnalisis = TipoAnalisis::count();

        // Clientes agrupados por mes
        $clientesDB = Cliente::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // Inicializamos los 12 meses en 0
        $this->clientesPorMes = array_fill(1, 12, 0);

        // Reemplazamos con los datos de la BD
        foreach ($clientesDB as $mes => $total) {
            $this->clientesPorMes[$mes] = $total;
        }

        // Dejamos listo para Chart.js (índices 0-11)
        $this->clientesPorMes = array_values($this->clientesPorMes);
    }

    public function render()
    {
        // Agrupamos análisis por tipo
        $analisisCategorias = Analisis::with('tipoAnalisis')
            ->get()
            ->groupBy('tipoAnalisis.nombre')
            ->map(fn($items) => $items->count())
            ->toArray();

        return view('livewire.dashboard-stats', [
            'clientesPorMes' => $this->clientesPorMes,
            'analisisCategorias' => $analisisCategorias
        ]);
    }
}
