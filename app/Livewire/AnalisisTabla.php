<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Analisis;
use Livewire\Attributes\On;

class AnalisisTabla extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar analisis?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-analisis',
        ]);
    }

    #[On('delete-analisis')]
    public function deleteAnalisis($id)
    {
        if (!checkPermiso('analisis.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este analisis'
            ]);
            return;
        }

        Analisis::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El analisis fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando cambias el texto de búsqueda
    }

    public function render()
    {
        $analisis = Analisis::whereHas('cliente', function ($query) {
            $query->where('nombre', 'like', '%'.$this->search.'%');
        })
        ->paginate(10);

        return view('livewire.analisis-tabla', [
            'analisis' => $analisis,
        ]);
    }
}
