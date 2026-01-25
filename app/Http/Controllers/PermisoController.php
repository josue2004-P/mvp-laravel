<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        if (!checkPermiso('permisos.is_read')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $permisos = Permiso::all();
        return view('pages.permisos.index', compact('permisos'));
    }

    public function create()
    {
        if (!checkPermiso('permisos.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        return view('pages.permisos.create');
    }

    public function store(Request $request)
    {
        if (!checkPermiso('permisos.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }

        $request->validate([
            'nombre' => 'required|unique:permisos,nombre',
            'descripcion' => 'nullable|string'
        ]);

        $request->merge([
            'nombre' => strtolower(trim($request->nombre))
        ]);

        Permiso::create($request->only('nombre', 'descripcion'));

        return redirect()->route('permisos.index')->with('success', 'Permiso creado.');
    }

    public function edit(Permiso $permiso)
    {
        if (!checkPermiso('permisos.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }

        return view('pages.permisos.edit', compact('permiso'));
    }

    public function update(Request $request, Permiso $permiso)
    {
        if (!checkPermiso('permisos.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }

        $request->merge([
            'nombre' => strtolower(trim($request->nombre))
        ]);
        
        $request->validate([
            'nombre' => 'required|unique:permisos,nombre,' . $permiso->id,
            'descripcion' => 'nullable|string'
        ]);

        $permiso->update($request->only('nombre', 'descripcion'));

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado.');
    }

    public function destroy(Permiso $permiso)
    {
        if (!checkPermiso('permisos.is_delete')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        
        $permiso->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado.');
    }
}
