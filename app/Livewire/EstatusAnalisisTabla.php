<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EstatusAnalisis;
use Livewire\Attributes\On;

class EstatusAnalisisTabla extends Component
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
            'title' => '¿Eliminar estatus de analisis?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-estatus-analisis',
        ]);
    }

    #[On('delete-estatus-analisis')]
    public function deletePermiso($id)
    {
        if (!checkPermiso('est-als.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este estatus'
            ]);
            return;
        }

        EstatusAnalisis::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El estatus fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $estatusAnalisis = EstatusAnalisis::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);
        return view('livewire.estatus-analisis-tabla',[
            'estatusAnalisis' => $estatusAnalisis,
        ]);
    }
}
