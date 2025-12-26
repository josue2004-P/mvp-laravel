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

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {

        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar permiso?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
        ]);
    }

    #[On('delete-permiso')]
    public function deletePermiso($id)
    {
        Permiso::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El permiso fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); 
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
