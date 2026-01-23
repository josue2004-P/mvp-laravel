<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HemogramaCompleto;
use App\Models\CategoriaHemogramaCompleto;
use Livewire\Attributes\On;

class HemogramaTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $categoriaHemogramaCompletoId = '';
    public $perPage = 7;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoriaHemogramaCompletoId' => ['except' => ''],
        'perPage' => ['except' => 7],
    ];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedCategoriaHemogramaCompletoId() { $this->resetPage(); }
    public function updatedPerPage(){$this->resetPage();}
    
    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar hemograma?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-hemograma',
        ]);
    }

    #[On('delete-hemograma')]
    public function deleteHemograma($id)
    {
        if (!checkPermiso('hemograma-completo.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este hemograma'
            ]);
            return;
        }

        HemogramaCompleto::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El hemograma fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando cambias el texto de búsqueda
    }

    public function render()
    {
        $categoriasHemogramaCompleto = CategoriaHemogramaCompleto::all();
        $hemogramas = HemogramaCompleto::with(['categoria', 'unidad'])
            ->where('nombre', 'like', '%'.$this->search.'%')
            ->when($this->categoriaHemogramaCompletoId, function ($query) {
                $query->where('categoria_hemograma_completo_id', $this->categoriaHemogramaCompletoId);
            })
            ->paginate($this->perPage);

        return view('livewire.hemograma-tabla', compact('hemogramas', 'categoriasHemogramaCompleto'));

    }
}
