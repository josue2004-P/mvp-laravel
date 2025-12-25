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
        $tipoAnalisis->load('hemogramas'); // carga la relación muchos a muchos
        return view('pages.tipo_analisis.edit', compact('tipoAnalisis', 'hemogramas'));
    }

    public function update(Request $request, TipoAnalisis $tipoAnalisis)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'hemogramas' => 'array', // opcional
            'hemogramas.*' => 'integer|exists:hemograma_completo,id'
        ]);

        $tipoAnalisis->update($request->only('nombre'));

        // Sincroniza la relación muchos a muchos
        $tipoAnalisis->hemogramas()->sync($request->hemogramas ?? []);

        return redirect()->route('tipo_analisis.index')->with('success', 'Tipo de análisis actualizado correctamente.');
    }

    public function destroy(TipoAnalisis $tipoAnalisis)
    {
        $tipoAnalisis->delete();
        return redirect()->route('tipo_analisis.index')->with('success', 'Tipo de análisis eliminado correctamente');
    }
}
