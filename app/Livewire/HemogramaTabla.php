<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HemogramaCompleto;
use Livewire\Attributes\On;

class HemogramaTabla extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar hemograma?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-hemograma',
        ]);
    }

    #[On('delete-hemograma')]
    public function deleteHemograma($id)
    {
        if (!checkPermiso('hemograma-completo.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este hemograma'
            ]);
            return;
        }

        HemogramaCompleto::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El hemograma fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando cambias el texto de búsqueda
    }

    public function render()
    {
        $hemogramas = HemogramaCompleto::with(['categoria', 'unidad'])
            ->where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.hemograma-tabla', [
            'hemogramas' => $hemogramas,
        ]);
    }
}
