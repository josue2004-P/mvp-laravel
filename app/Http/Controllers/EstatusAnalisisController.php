<?php

namespace App\Http\Controllers;

use App\Models\EstatusAnalisis;
use Illuminate\Http\Request;

class EstatusAnalisisController extends Controller
{
    // Listar todos los registros
    public function index()
    {
        $estatus = EstatusAnalisis::all();
        return view('pages.estatus-analisis.index', compact('estatus'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('pages.estatus-analisis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:255',
            'descripcion'     => 'nullable|string|max:255',
            'colorTexto'      => 'nullable|string|max:10',
            'colorFondo'      => 'nullable|string|max:10',
            'analsisAbierto'  => 'nullable',
            'analisisCerrado' => 'nullable',
        ]);

        try {
            EstatusAnalisis::create([
                'nombre'           => $validated['nombre'],
                'descripcion'      => $validated['descripcion'] ?? '',
                
                'color_texto'      => $validated['colorTexto'] ?? '#000000',
                'color_fondo'      => $validated['colorFondo'] ?? '#FFFFFF',
                
                'analisis_abierto' => $request->has('analsisAbierto') ? 1 : 0,
                'analisis_cerrado' => $request->has('analisisCerrado') ? 1 : 0,
            ]);

            return redirect()
                ->route('estatus-analisis.index')
                ->with('success', 'Estatus de análisis registrado con éxito.');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    // Mostrar formulario de edición
    public function edit(EstatusAnalisis $estatus)
    {
        return view('pages.estatus-analisis.edit', ['estatus' => $estatus]);
    }

    public function update(Request $request, EstatusAnalisis $estatus)
    {
        $validated = $request->validate([
            'nombreCorto'     => 'required|string|max:255',
            'descripcion'     => 'required|string|max:255',
            'colorTexto'      => 'nullable|string|max:10',
            'colorFondo'      => 'nullable|string|max:10',
            'analsisAbierto'  => 'nullable',
            'analisisCerrado' => 'nullable',
        ]);

        try {
            $estatus->update([
                'nombre'           => $validated['nombreCorto'],
                'descripcion'      => $validated['descripcion'],
                'color_texto'      => $validated['colorTexto'],
                'color_fondo'      => $validated['colorFondo'],
                'analisis_abierto' => $request->has('analsisAbierto') ? 1 : 0,
                'analisis_cerrado' => $request->has('analisisCerrado') ? 1 : 0,
            ]);

            return redirect()->route('estatus-analisis.index')
                ->with('success', 'Estatus actualizado correctamente.');

        } catch (\Exception $e) {

            return back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    // Eliminar registro
    public function destroy(EstatusAnalisis $estatusAnalise)
    {
        $estatusAnalise->delete();
        return redirect()->route('estatus-analisis.index')
                         ->with('success', 'Estatus eliminado.');
    }
}