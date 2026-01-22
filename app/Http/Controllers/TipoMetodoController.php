<?php

namespace App\Http\Controllers;

use App\Models\TipoMetodo;
use Illuminate\Http\Request;

class TipoMetodoController extends Controller
{
    public function index()
    {
        $metodos = TipoMetodo::all();
        return view('pages.tipo_metodo.index', compact('metodos'));
    }

    public function create()
    {
        return view('pages.tipo_metodo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_metodos,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        try {
            TipoMetodo::create($validated);
            return redirect()->route('tipo_metodo.index')
                ->with('success', 'Método "' . $request->nombre . '" registrado correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error al crear tipo_metodo: " . $e->getMessage());
            return back()->withInput()->with('error', 'No se pudo guardar el método.');
        }
    }

    public function edit(TipoMetodo $tipoMetodo)
    {
        return view('pages.tipo_metodo.edit', compact('tipoMetodo'));
    }

    public function update(Request $request, TipoMetodo $tipoMetodo)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_metodos,nombre,' . $tipoMetodo->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        try {
            $tipoMetodo->update($validated);
            return redirect()->route('tipo_metodo.index')
                ->with('success', 'Metodología actualizada exitosamente.');
        } catch (\Exception $e) {
            \Log::error("Error al actualizar tipo_metodo: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error al procesar la actualización.');
        }
    }

    public function destroy(TipoMetodo $tipoMetodo)
    {
        $tipoMetodo->delete();
        return redirect()->route('tipo_metodo.index')->with('success', 'Método eliminado correctamente');
    }
}
