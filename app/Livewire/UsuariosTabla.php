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
            'title' => '¿Eliminar usuario?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-usuario',
        ]);
    }

    #[On('delete-usuario')]
    public function deletePermiso($id)
    {
        if (!checkPermiso('usuario.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este usuario'
            ]);
            return;
        }

        User::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El usuario fue eliminado correctamente'
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
