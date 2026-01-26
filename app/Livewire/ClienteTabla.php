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
    public $perPage = 7;

    // Esto mantiene los filtros en la URL del navegador
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' =>  7],
    ];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedPerPage(){$this->resetPage();}

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
        if (!checkPermiso('clientes.is_delete')) {
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
        $clientes = Cliente::where(function($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('calle', 'like', '%' . $this->search . '%')
                    ->orWhere('ciudad', 'like', '%' . $this->search . '%')
                    ->orWhere('estado', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.cliente-tabla', [
            'clientes' => $clientes,
        ]);
    }
}


