<?php

namespace App\Livewire;
use Livewire\WithPagination;
use App\Models\CategoriaHemogramaCompleto;
use Livewire\Attributes\On; 

use Livewire\Component;

class CategoriaHemogramaTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedPerPage(){$this->resetPage();}

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar categoria hemograma?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-categoria-hemograma',
        ]);
    }

    #[On('delete-categoria-hemograma')]
    public function deleteCategoriaHemograma($id)
    {
        if (!checkPermiso('categoria-hemograma.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar esta categoria hemograma'
            ]);
            return;
        }

        CategoriaHemogramaCompleto::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'La categoria hemograma fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $categorias = CategoriaHemogramaCompleto::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.categoria-hemograma-tabla',[
            'categorias' => $categorias,
        ]);
    }
}
