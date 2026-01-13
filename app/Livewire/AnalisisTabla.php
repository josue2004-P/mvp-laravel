<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Analisis;
use App\Models\TipoAnalisis;
use App\Models\Doctor;
use Livewire\Attributes\On;

class AnalisisTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoAnalisisId = '';
    public $doctorId = '';

    // Esto mantiene los filtros en la URL del navegador
    protected $queryString = [
        'search' => ['except' => ''],
        'tipoAnalisisId' => ['except' => ''],
        'doctorId' => ['except' => ''],
    ];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';
    
    public function updatedSearch() { $this->resetPage(); }
    public function updatedTipoAnalisisId() { $this->resetPage(); }
    public function updatedDoctorId() { $this->resetPage(); }

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar analisis?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-analisis',
        ]);
    }

    #[On('delete-analisis')]
    public function deleteAnalisis($id)
    {
        if (!checkPermiso('analisis.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este analisis'
            ]);
            return;
        }

        Analisis::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El analisis fue eliminado correctamente'
        ]);
    }
    
    public function render()
    {
        $doctores = Doctor::all(); // Asegúrate de enviarlos a la vista
        $tipoAnalisis = TipoAnalisis::all();

        $analisis = Analisis::with(['cliente', 'doctor', 'tipoAnalisis'])
            ->whereHas('cliente', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            })
            ->when($this->tipoAnalisisId, function ($query) {
                $query->where('idTipoAnalisis', $this->tipoAnalisisId);
            })
            ->when($this->doctorId, function ($query) {
                $query->where('idDoctor', $this->doctorId);
            })
            ->paginate(10);

        return view('livewire.analisis-tabla', compact('analisis', 'tipoAnalisis', 'doctores'));
    }
}
