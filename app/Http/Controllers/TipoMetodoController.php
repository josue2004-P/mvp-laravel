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
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_metodos,nombre',
        ]);

        TipoMetodo::create($request->all());

        return redirect()->route('tipo_metodo.index')->with('success', 'Método creado correctamente');
    }

    public function edit(TipoMetodo $tipoMetodo)
    {
        return view('pages.tipo_metodo.edit', compact('tipoMetodo'));
    }

    public function update(Request $request, TipoMetodo $tipoMetodo)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_metodos,nombre,' . $tipoMetodo->id,
        ]);

        $tipoMetodo->update($request->all());

        return redirect()->route('tipo_metodo.index')->with('success', 'Método actualizado correctamente');
    }

    public function destroy(TipoMetodo $tipoMetodo)
    {
        $tipoMetodo->delete();
        return redirect()->route('tipo_metodo.index')->with('success', 'Método eliminado correctamente');
    }
}
