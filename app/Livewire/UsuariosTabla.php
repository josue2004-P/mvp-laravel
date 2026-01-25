<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\On;

class UsuariosTabla extends Component
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
            'title' => '¿Desactivar usuario?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-usuario',
        ]);
    }

    public function confirmActive($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Activar usuario?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'active-usuario',
        ]);
    }

    #[On('delete-usuario')]
    public function deletePermiso($id)
    {
        if (!checkPermiso('usuarios.is_delete')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para desactivar este usuario'
            ]);
            return;
        }

        $usuario = User::findOrFail($id);

        $usuario->update([
            'is_activo' => false
        ]);

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Desactivado',
            'text'  => 'El usuario fue desactivado correctamente'
        ]);
    }

    #[On('active-usuario')]
    public function activarUsuario($id)
    {
        if (!checkPermiso('usuarios.is_update')) { 
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para activar este usuario'
            ]);
            return;
        }

        $usuario = User::findOrFail($id);
        $usuario->update(['is_activo' => true]);

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Activado',
            'text'  => 'El usuario vuelve a estar operativo'
        ]);
    }

    public function render()
    {
        $usuarios = User::where('name', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.usuarios-tabla',[
            'usuarios' => $usuarios,
        ]);
    }
}
