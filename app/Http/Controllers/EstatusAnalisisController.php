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
        EstatusAnalisis::create([
            'nombreCorto'     => $request->nombreCorto,
            'descripcion'     => $request->descripcion,
            'colorTexto'      => $request->colorTexto, // Usando CamelCase como en tu DB
            'colorFondo'      => $request->colorFondo,
            'analsisAbierto'  => $request->has('analsisAbierto') ? 1 : 0,
            'analisisCerrado' => $request->has('analisisCerrado') ? 1 : 0,
        ]);

        return redirect()->route('estatus-analisis.index');
    }

    // Mostrar formulario de edición
    public function edit(EstatusAnalisis $estatus)
    {
        return view('pages.estatus-analisis.edit', ['estatus' => $estatus]);
    }

    public function update(Request $request, EstatusAnalisis $estatus)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombreCorto' => 'required|max:50',
            'descripcion' => 'nullable|string',
            'colorTexto'  => 'nullable|string|max:7',
            'colorFondo'  => 'nullable|string|max:7',
        ]);

        // Actualizar el registro mapeando manualmente a las columnas de la DB
        $estatus->update([
            'nombreCorto'     => $request->nombreCorto,
            'descripcion'     => $request->descripcion,
            'colorTexto'      => $request->colorTexto,
            'colorFondo'      => $request->colorFondo,
            'analsisAbierto'  => $request->has('analsisAbierto') ? 1 : 0,
            'analisisCerrado' => $request->has('analisisCerrado') ? 1 : 0,
        ]);

        return redirect()->route('estatus-analisis.index')
            ->with('success', 'Estatus actualizado correctamente.');
    }

    // Eliminar registro
    public function destroy(EstatusAnalisis $estatusAnalise)
    {
        $estatusAnalise->delete();
        return redirect()->route('estatus-analisis.index')
                         ->with('success', 'Estatus eliminado.');
    }
}