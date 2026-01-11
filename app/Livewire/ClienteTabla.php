<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use Livewire\Attributes\On;

class ClienteTabla extends Component
{

    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar cliente?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'=> 'delete-cliente',
        ]);
    }

    #[On('delete-cliente')]
    public function deleteCliente($id)
    {
        if (!checkPermiso('clientes.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este cliente'
            ]);
            return;
        }

        Cliente::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El cliente fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando cambias el texto de búsqueda
    }

    public function render()
    {
        $clientes = Cliente::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.cliente-tabla', [
            'clientes' => $clientes,
        ]);
    }
}


