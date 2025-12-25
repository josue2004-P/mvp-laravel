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
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_muestras,nombre',
        ]);

        TipoMuestra::create($request->all());

        return redirect()->route('tipo_muestra.index')->with('success', 'Tipo de muestra creado correctamente');
    }

    public function edit(TipoMuestra $tipoMuestra)
    {
        return view('pages.tipo_muestra.edit', compact('tipoMuestra'));
    }

    public function update(Request $request, TipoMuestra $tipoMuestra)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_muestras,nombre,' . $tipoMuestra->id,
        ]);

        $tipoMuestra->update($request->all());

        return redirect()->route('tipo_muestra.index')->with('success', 'Tipo de muestra actualizado correctamente');
    }

    public function destroy(TipoMuestra $tipoMuestra)
    {
        $tipoMuestra->delete();
        return redirect()->route('tipo_muestra.index')->with('success', 'Tipo de muestra eliminado correctamente');
    }
}
