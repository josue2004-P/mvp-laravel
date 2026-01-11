<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Perfil;
use Livewire\Attributes\On;

class PerfilesTabla extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {

        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar perfil?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-perfil',
        ]);
    }

    #[On('delete-perfil')]
    public function deletePermiso($id)
    {
        if (!checkPermiso('permisos.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este permiso'
            ]);
            return;
        }

        Perfil::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El perfil fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $perfiles = Perfil::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);
        return view('livewire.perfiles-tabla',[
            'perfiles' => $perfiles,
        ]);
    }
}
