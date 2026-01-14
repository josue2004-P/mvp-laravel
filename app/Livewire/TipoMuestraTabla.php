<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoMuestra;
use Livewire\Attributes\On;

class TipoMuestraTabla extends Component
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
            'title' => '¿Eliminar tipo muestra?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-tipo-muestra',
        ]);
    }

    #[On('delete-tipo-muestra')]
    public function deleteTipoMuestra($id)
    {
        if (!checkPermiso('tipo-muestras.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este tipo de muestra'
            ]);
            return;
        }

        TipoMuestra::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El tipo de muestra fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $muestras = TipoMuestra::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.tipo-muestra-tabla',[
            'muestras' => $muestras,
        ]);
    }
}
