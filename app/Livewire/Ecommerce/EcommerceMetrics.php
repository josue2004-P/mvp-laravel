<?php

namespace App\Livewire\Ecommerce;

use Livewire\Component;

class EcommerceMetrics extends Component
{
    public $clientes;
    public $analisis;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.ecommerce.ecommerce-metrics');
    }
}
