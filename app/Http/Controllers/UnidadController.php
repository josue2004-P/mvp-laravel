<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function index()
    {
        $unidades = Unidad::all();
        return view('pages.unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('pages.unidades.create');
    }

    public function store(Request $request)
    {
        // 1. Validación de los campos según la migración
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:unidades,nombre',
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            // 2. Creación del registro
            // Nota: Eloquent maneja automáticamente created_at y updated_at
            Unidad::create($validated);

            return redirect()
                ->route('unidades.index')
                ->with('success', 'La unidad "' . $request->nombre . '" ha sido registrada correctamente.');

        } catch (\Exception $e) {
            Log::error("Error al crear unidad: " . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar. Intente de nuevo.');
        }
    }

    public function edit(Unidad $unidad)
    {
        return view('pages.unidades.edit', compact('unidad'));
    }

    public function update(Request $request, Unidad $unidade)
    {
        // 1. Validación con excepción de ID para permitir conservar el mismo nombre
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:unidades,nombre,' . $unidade->id,
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            // 2. Actualización de datos
            $unidade->update($validated);

            return redirect()
                ->route('unidades.index')
                ->with('success', 'La unidad se ha actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error("Error al actualizar unidad ID {$unidade->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'No se pudieron guardar los cambios en la unidad.');
        }
    }

    public function destroy(Unidad $unidad)
    {
        $unidad->delete();
        return redirect()->route('unidades.index')->with('success', 'Unidad eliminada.');
    }
}
