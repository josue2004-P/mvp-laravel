<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Unidad;
use Livewire\Attributes\On;

class UnidadTabla extends Component
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
            'title' => '¿Eliminar unidad?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'=> 'delete-unidad',
        ]);
    }

    #[On('delete-unidad')]
    public function deleteUnidad($id)
    {
        if (!checkPermiso('unidades.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar esta unidad'
            ]);
            return;
        }

        Unidad::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'La unidad fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $unidades = Unidad::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);
        return view('livewire.unidad-tabla',[
            'unidades' => $unidades,
        ]);
    }
}
