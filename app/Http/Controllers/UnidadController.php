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
        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        Unidad::create([
            'nombre' => $request->nombre,
            'fechaCreacion' => now(),
            'fechaActualizacion' => now(),
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidad creada correctamente.');
    }

    public function edit(Unidad $unidad)
    {
        return view('pages.unidades.edit', compact('unidad'));
    }

    public function update(Request $request, Unidad $unidad)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
        ]);

        $unidad->update([
            'nombre' => $request->nombre,
            'fechaActualizacion' => now(),
        ]);

        return redirect()->route('unidades.index')->with('success', 'Unidad actualizada correctamente.');
    }

    public function destroy(Unidad $unidad)
    {
        $unidad->delete();
        return redirect()->route('unidades.index')->with('success', 'Unidad eliminada.');
    }
}
