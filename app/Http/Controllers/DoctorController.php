<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        if (!checkPermiso('doctores.is_read')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $doctores = Doctor::all();
        $especialidades = Especialidad::all();

        return view('pages.doctores.index', compact('doctores','especialidades'));
    }

    public function create()
    {
        if (!checkPermiso('doctores.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $especialidades = Especialidad::all();
        return view('pages.doctores.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        if (!checkPermiso('doctores.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $validated = $request->validate([
            'nombre'             => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'cedula_profesional' => 'required|string|max:50|unique:doctores,cedula_profesional',
            'especialidades'     => 'required|array|min:1',
            'especialidades.*'   => 'exists:especialidades,id',
            'email'              => 'nullable|email|max:255|unique:doctores,email',
            'telefono'           => 'nullable|string|max:20',
        ]);

        try {
            $dataDoctor = $validated;
            unset($dataDoctor['especialidades']);
            $dataDoctor['is_activo'] = true;

            $doctor = Doctor::create($dataDoctor);
            
            $doctor->especialidades()->attach($request->especialidades);
            
            return redirect()
                ->route('doctores.index')
                ->with('success', 'El Dr. ' . $request->nombre . ' ' . $request->apellido_paterno . ' ha sido registrado exitosamente.');

        } catch (\Exception $e) {
            \Log::error("Error al registrar doctor: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error inesperado al guardar el registro. Por favor, intente de nuevo.');
        }
    }

    public function edit(Doctor $doctor)
    {
        if (!checkPermiso('doctores.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $especialidades = Especialidad::all();
        return view('pages.doctores.edit', compact('doctor','especialidades'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        if (!checkPermiso('doctores.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $validated = $request->validate([
            'nombre'             => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'cedula_profesional' => 'required|string|max:50|unique:doctores,cedula_profesional,' . $doctor->id,
            'especialidades'     => 'required|array|min:1',
            'especialidades.*'   => 'exists:especialidades,id',
            'email'              => 'nullable|email|max:255|unique:doctores,email,' . $doctor->id,
            'telefono'           => 'nullable|string|max:20',
        ]);

        try {
            $dataDoctor = $validated;
            unset($dataDoctor['especialidades']);

            $doctor->update($dataDoctor);
            
            // sync() es clave aquí: quita las que ya no están y agrega las nuevas
            $doctor->especialidades()->sync($request->especialidades);
            
            return redirect()
                ->route('doctores.index')
                ->with('success', 'La información del Dr. ' . $doctor->nombre . ' ha sido actualizada.');

        } catch (\Exception $e) {
            \Log::error("Error al actualizar doctor: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error al intentar actualizar el registro.');
        }
    }

    public function destroy(Doctor $doctor)
    {
        if (!checkPermiso('doctores.is_delete')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado correctamente');
    }
}
