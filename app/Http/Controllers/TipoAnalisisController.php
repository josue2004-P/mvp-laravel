<?php

namespace App\Http\Controllers;

use App\Models\TipoAnalisis;
use App\Models\HemogramaCompleto;
use Illuminate\Http\Request;

class TipoAnalisisController extends Controller
{
    public function index()
    {
        $tipos = TipoAnalisis::all();
        return view('pages.tipo_analisis.index', compact('tipos'));
    }

    public function create()
    {
        return view('pages.tipo_analisis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_analisis,nombre',
        ]);

        TipoAnalisis::create($request->all());

        return redirect()->route('tipo_analisis.index')->with('success', 'Tipo de análisis creado correctamente');
    }

    public function edit(TipoAnalisis $tipoAnalisis)
    {
        $hemogramas = HemogramaCompleto::all();
        $tipoAnalisis->load('parametrosHemograma'); 
        return view('pages.tipo_analisis.edit', compact('tipoAnalisis', 'hemogramas'));
    }

    public function update(Request $request, TipoAnalisis $tipoAnalisis)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_analisis,nombre,' . $tipoAnalisis->id,
            'hemogramas' => 'nullable|array',
            'hemogramas.*' => 'integer|exists:hemograma_completo,id'
        ]);

        try {
            $tipoAnalisis->update([
                'nombre' => $validated['nombre']
            ]);

            $tipoAnalisis->parametrosHemograma()->sync($request->input('hemogramas', []));

            return redirect()
                ->route('tipo_analisis.index')
                ->with('success', 'El perfil "' . $tipoAnalisis->nombre . '" y sus parámetros se actualizaron correctamente.');

        } catch (\Exception $e) {
            \Log::error("Error al actualizar TipoAnalisis ID {$tipoAnalisis->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error inesperado al procesar la actualización.');
        }
    }

    public function destroy(TipoAnalisis $tipoAnalisis)
    {
        $tipoAnalisis->delete();
        return redirect()->route('tipo_analisis.index')->with('success', 'Tipo de análisis eliminado correctamente');
    }
}
