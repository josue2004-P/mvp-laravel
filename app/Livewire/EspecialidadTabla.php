<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Especialidad;
use Livewire\Attributes\On;

class EspecialidadTabla extends Component
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
            'title' => '¿Eliminar la especialidad?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'    => 'delete-especialidad',
        ]);
    }

    #[On('delete-especialidad')]
    public function deleteEspecialidad($id)
    {
        if (!checkPermiso('especialidades.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar esta especialidad'
            ]);
            return;
        }

        Especialidad::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El tipo de metodo fue eliminado correctamente'
        ]);
    }

    public function render()
    {
        $especialidades = Especialidad::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.especialidad-tabla',[
            'especialidades' => $especialidades,
        ]);
    }
}
