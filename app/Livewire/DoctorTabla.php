<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Doctor;
use Livewire\Attributes\On;

class DoctorTabla extends Component
{
    use WithPagination;

    public $search = '';

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function confirmDelete($id)
    {
        $this->dispatch('swal-confirm', [
            'title' => '¿Eliminar doctor?',
            'text'  => 'Esta acción no se puede deshacer',
            'icon'  => 'warning',
            'id'    => $id,
            'function'=> 'delete-doctor',
        ]);
    }

    #[On('delete-doctor')]
    public function deleteDoctor($id)
    {
        if (!checkPermiso('doctores.eliminar')) {
            $this->dispatch('swal-init', [
                'icon'  => 'error',
                'title' => 'Acceso Denegado',
                'text'  => 'No tienes permisos para eliminar este doctor'
            ]);
            return;
        }

        Doctor::findOrFail($id)->delete();

        $this->dispatch('swal-init', [
            'icon'  => 'success',
            'title' => 'Eliminado',
            'text'  => 'El doctor fue eliminado correctamente'
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $doctores = Doctor::where('nombre', 'like', '%'.$this->search.'%')
            ->paginate(10);
        return view('livewire.doctor-tabla',[
            'doctores' => $doctores,
        ]);
    }
}
