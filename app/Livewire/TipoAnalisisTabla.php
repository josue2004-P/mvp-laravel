<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TipoAnalisis;
use Livewire\Attributes\On;

class TipoAnalisisTabla extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar tipo analisis?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-tipo-analisis',
        ]);
    }

    #[On('delete-tipo-analisis')]
    public function deleteTipoAnalisis($id)
    {
        if (!checkPermiso('tipo-muestras.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este tipo de analisis'
            ]);
            return;
        }

        TipoAnalisis::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El tipo de analisis fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando cambias el texto de búsqueda
    }

    public function render()
    {
        $tipos = TipoAnalisis::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.tipo-analisis-tabla',[
            'tipos' => $tipos,
        ]);
    }
}
