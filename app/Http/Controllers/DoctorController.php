<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctores = Doctor::all();
        $especialidades = Especialidad::all();

        return view('pages.doctores.index', compact('doctores','especialidades'));
    }

    public function create()
    {
        $especialidades = Especialidad::all();
        return view('pages.doctores.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'             => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'cedula_profesional' => 'required|string|max:50|unique:doctores,cedula_profesional',
            'especialidad_id'    => 'required|exists:especialidades,id',
            'email'              => 'nullable|email|max:255|unique:doctores,email',
            'telefono'           => 'nullable|string|max:20',
        ]);

        try {
            $validated['is_activo'] = true;

            Doctor::create($validated);
            
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
        $especialidades = Especialidad::all();
        return view('pages.doctores.edit', compact('doctor','especialidades'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'nombre'             => 'required|string|max:100',
            'apellido_paterno'   => 'required|string|max:100',
            'apellido_materno'   => 'nullable|string|max:100',
            'cedula_profesional' => 'required|string|max:50|unique:doctores,cedula_profesional,' . $doctor->id,
            'especialidad_id'    => 'required|exists:especialidades,id',
            'email'              => 'nullable|email|max:255|unique:doctores,email,' . $doctor->id,
            'telefono'           => 'nullable|string|max:20',
            'is_activo'          => 'required|boolean',
        ]);

        try {
            $doctor->update($validated);

            return redirect()
                ->route('doctores.index')
                ->with('success', 'La información del Dr. ' . $doctor->apellido_paterno . ' se actualizó correctamente.');

        } catch (\Exception $e) {
            \Log::error("Error actualizando doctor ID {$doctor->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al procesar la actualización.');
        }
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado correctamente');
    }
}
