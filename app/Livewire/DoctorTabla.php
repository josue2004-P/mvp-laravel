<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Doctor;
use App\Models\Especialidad;

use Livewire\Attributes\On;

class DoctorTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $especialidadId = '';
    public $perPage = 7;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 7],
        'especialidadId' => ['except' => ''],
    ];

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedPerPage(){$this->resetPage();}
    public function updatedEspecialidadId() { $this->resetPage(); }


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

    public function render()
    {
        $especialidades = Especialidad::all();
        $doctores = Doctor::where('nombre', 'like', '%'.$this->search.'%')
            ->when($this->especialidadId, function ($query) {
                $query->where('especialidad_Id', $this->especialidadId);
            })
            ->paginate($this->perPage);
        return view('livewire.doctor-tabla',[
            'doctores' => $doctores,
             'especialidades' =>  $especialidades
        ]);
    }
}
