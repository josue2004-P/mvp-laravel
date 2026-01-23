<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Analisis;
use App\Models\TipoAnalisis;
use App\Models\TipoMetodo;
use App\Models\TipoMuestra;
use App\Models\Doctor;
use Livewire\Attributes\On;

class AnalisisTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $doctorId = '';
    public $tipoAnalisisId = '';
    public $tipoMuestraId = '';
    public $tipoMetodoId = '';
    public $perPage = 6;

    // Esto mantiene los filtros en la URL del navegador
    protected $queryString = [
        'search' => ['except' => ''],
        'tipoAnalisisId' => ['except' => ''],
        'doctorId' => ['except' => ''],
        'tipoMuestraId' => ['except' => ''],
        'tipoMetodoId' => ['except' => ''],
        'perPage' => ['except' => 6],
    ];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';
    
    public function updatedSearch() { $this->resetPage(); }
    public function updatedTipoAnalisisId() { $this->resetPage(); }
    public function updatedDoctorId() { $this->resetPage(); }
    public function updatedTipoMuestraId() { $this->resetPage(); }
    public function updatedTipoMetodoId() { $this->resetPage(); }
    public function updatedPerPage(){$this->resetPage();}

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
        $tipoMetodos = TipoMetodo::all();
        $tipoMuestras = TipoMuestra::all();

        $analisis = Analisis::with(['cliente', 'doctor', 'tipoAnalisis'])
            ->whereHas('cliente', function ($query) {
                $query->where('nombre', 'like', '%'.$this->search.'%');
            })
            ->when($this->tipoAnalisisId, function ($query) {
                $query->where('tipo_analisis_id', $this->tipoAnalisisId);
            })
            ->when($this->doctorId, function ($query) {
                $query->where('doctor_id', $this->doctorId);
            })
            ->paginate($this->perPage);

        return view('livewire.analisis-tabla', compact('analisis', 'tipoAnalisis', 'doctores','tipoMetodos','tipoMuestras'));
    }
}
