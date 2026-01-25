<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Permiso;
use Livewire\Attributes\On;

class PermisosTabla extends Component
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
            'title' => '¿Eliminar permiso?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-permiso',
        ]);
    }

    #[On('delete-permiso')]
    public function deletePermiso($id)
    {
        if (!checkPermiso('permisos.is_delete')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este permiso'
            ]);
            return;
        }

        Permiso::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El permiso fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $permisos = Permiso::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);
        return view('livewire.permisos-tabla',[
            'permisos' => $permisos,
        ]);
    }
}
