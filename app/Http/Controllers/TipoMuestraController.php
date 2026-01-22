<?php

namespace App\Http\Controllers;

use App\Models\TipoMuestra;
use Illuminate\Http\Request;

class TipoMuestraController extends Controller
{
    public function index()
    {
        $muestras = TipoMuestra::all();
        return view('pages.tipo_muestra.index', compact('muestras'));
    }

    public function create()
    {
        return view('pages.tipo_muestra.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_muestras,nombre',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        try {
            TipoMuestra::create($validated);

            return redirect()
                ->route('tipo_muestra.index')
                ->with('success', 'El tipo de muestra "' . $request->nombre . '" se ha registrado correctamente.');

        } catch (\Exception $e) {
            Log::error("Error al crear tipo_muestra: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un problema al guardar la información. Por favor, intente de nuevo.');
        }
    }

    public function edit(TipoMuestra $tipoMuestra)
    {
        return view('pages.tipo_muestra.edit', compact('tipoMuestra'));
    }

    public function update(Request $request, TipoMuestra $tipoMuestra)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipo_muestras,nombre,' . $tipoMuestra->id,
            'descripcion' => 'nullable|string|max:1000',
        ]);

        try {
            $tipoMuestra->update($validated);

            return redirect()
                ->route('tipo_muestra.index')
                ->with('success', 'La información de la muestra ha sido actualizada exitosamente.');

        } catch (\Exception $e) {
            Log::error("Error al actualizar tipo_muestra ID {$tipoMuestra->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'No se pudieron guardar los cambios en el registro.');
        }
    }

    public function destroy(TipoMuestra $tipoMuestra)
    {
        $tipoMuestra->delete();
        return redirect()->route('tipo_muestra.index')->with('success', 'Tipo de muestra eliminado correctamente');
    }
}
