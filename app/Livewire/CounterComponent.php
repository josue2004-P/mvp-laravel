<?php

namespace App\Livewire;

use Livewire\Component;

class CounterComponent extends Component
{
    public $search = 'search'; // variable pública

    public function render()
    {
        return view('livewire.counter-component');
    }


}
