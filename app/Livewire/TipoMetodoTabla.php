<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoMetodo;
use Livewire\Attributes\On;

class TipoMetodoTabla extends Component
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
            'title' => '¿Eliminar tipo metodo?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-tipo-metodo',
        ]);
    }

    #[On('delete-tipo-metodo')]
    public function deleteTipoMetodo($id)
    {
        if (!checkPermiso('tipo-metodos.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este tipo de metodo'
            ]);
            return;
        }

        TipoMetodo::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El tipo de metodo fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $metodos = TipoMetodo::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.tipo-metodo-tabla',[
            'metodos' => $metodos,
        ]);
    }
}
