<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        if (!checkPermiso('permisos.leer')) {
            abort(403, 'Operación sin permisos');
        }
        $permisos = Permiso::all();
        return view('pages.permisos.index', compact('permisos'));
    }

    public function create()
    {
        if (!checkPermiso('permisos.crear')) {
            abort(403, 'Operación sin permisos');
        }
        return view('pages.permisos.create');
    }

    public function store(Request $request)
    {
        if (!checkPermiso('permisos.crear')) {
            abort(403, 'Operación sin permisos');
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
        if (!checkPermiso('permisos.actualizar')) {
            abort(403, 'Operación sin permisos');
        }
        return view('pages.permisos.edit', compact('permiso'));
    }

    public function update(Request $request, Permiso $permiso)
    {
        if (!checkPermiso('permisos.actualizar')) {
            abort(403, 'Operación sin permisos');
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
        if (!checkPermiso('permisos.eliminar')) {
            abort(403, 'Operación sin permisos');
        }
        
        $permiso->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado.');
    }
}
