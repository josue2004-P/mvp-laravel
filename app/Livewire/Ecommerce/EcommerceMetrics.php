<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Analisis;

class EcommerceMetrics extends Component
{
    public $clientes;
    public $analisis;

    public function mount()
    {
        $this->clientes = Cliente::all();
        $this->analisis = Analisis::all();
    }

    public function render()
    {
        return view('livewire.ecommerce.ecommerce-metrics');
    }
}
