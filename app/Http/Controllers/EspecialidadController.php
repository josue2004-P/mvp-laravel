<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index() {
        if (!checkPermiso('esp-doctor.is_read')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $especialidades = Especialidad::all();
        return view('pages.especialidades.index', compact('especialidades'));
    }

    public function create() {
        if (!checkPermiso('esp-doctor.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        return view('pages.especialidades.create');
    }

    public function store(Request $request) 
    {
        if (!checkPermiso('esp-doctor.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $validated = $request->validate([
            'nombre'      => 'required|unique:especialidades,nombre|max:255',
            'descripcion' => 'nullable|string|max:1000', // Agregamos validación de descripción
        ]);

        try {
            Especialidad::create($validated);
            return redirect()->route('especialidades.index')
                ->with('success', 'Especialidad "' . $request->nombre . '" creada con éxito.');
        } catch (\Exception $e) {
            Log::error("Error al crear especialidad: " . $e->getMessage());
            return back()->withInput()->with('error', 'No se pudo crear el registro.');
        }
    }

    public function edit(Especialidad $especialidad) {
        if (!checkPermiso('esp-doctor.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        return view('pages.especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, Especialidad $especialidad) 
    {
        if (!checkPermiso('esp-doctor.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $validated = $request->validate([
            'nombre'      => 'required|max:255|unique:especialidades,nombre,' . $especialidad->id,
            'descripcion' => 'nullable|string|max:1000', // Validamos la descripción en el update
        ]);

        try {
            $especialidad->update($validated);
            return redirect()->route('especialidades.index')
                ->with('success', 'Especialidad actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al editar especialidad ID {$especialidad->id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar los datos.');
        }
    }

    public function destroy(Especialidad $especialidad) 
    {
        if (!checkPermiso('esp-doctor.is_delete')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        try {
            // Verificamos si tiene doctores antes de borrar (opcional por integridad)
            if ($especialidad->doctores()->count() > 0) {
                return back()->with('error', 'No se puede eliminar una especialidad que tiene doctores asignados.');
            }

            $especialidad->delete();
            return redirect()->route('especialidades.index')->with('success', 'Eliminada con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al intentar eliminar.');
        }
    }
}