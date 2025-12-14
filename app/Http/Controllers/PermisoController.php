<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::all();
        return view('pages.permisos.index', compact('permisos'));
    }

    public function create()
    {
        return view('pages.permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre',
            'descripcion' => 'nullable|string'
        ]);

        Permiso::create($request->only('nombre', 'descripcion'));

        return redirect()->route('permisos.index')->with('success', 'Permiso creado.');
    }

    public function edit(Permiso $permiso)
    {
        return view('pages.permisos.edit', compact('permiso'));
    }

    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre,' . $permiso->id,
            'descripcion' => 'nullable|string'
        ]);

        $permiso->update($request->only('nombre', 'descripcion'));

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado.');
    }

    public function destroy(Permiso $permiso)
    {
        $permiso->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado.');
    }
}
