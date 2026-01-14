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

    // Guardar nuevo registro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion'     => 'required|string|max:30',
            'nombreCorto'     => 'required|string|max:10',
            'colorTexto'      => 'nullable|string|max:10',
            'colorFondo'      => 'nullable|string|max:10',
            'analsisAbierto'  => 'boolean',
            'analisisCerrado' => 'boolean',
        ]);

        EstatusAnalisis::create($validated);

        return redirect()->route('estatus-analisis.index')
                         ->with('success', 'Estatus creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(EstatusAnalisis $estatusAnalise)
    {
        return view('pages.estatus-analisis.edit', ['estatus' => $estatusAnalise]);
    }

    // Actualizar registro
    public function update(Request $request, EstatusAnalisis $estatusAnalise)
    {
        $validated = $request->validate([
            'descripcion'     => 'required|string|max:30',
            'nombreCorto'     => 'required|string|max:10',
            'colorTexto'      => 'nullable|string|max:10',
            'colorFondo'      => 'nullable|string|max:10',
            'analsisAbierto'  => 'boolean',
            'analisisCerrado' => 'boolean',
        ]);

        $estatusAnalise->update($validated);

        return redirect()->route('estatus-analisis.index')
                         ->with('success', 'Estatus actualizado.');
    }

    // Eliminar registro
    public function destroy(EstatusAnalisis $estatusAnalise)
    {
        $estatusAnalise->delete();
        return redirect()->route('estatus-analisis.index')
                         ->with('success', 'Estatus eliminado.');
    }
}