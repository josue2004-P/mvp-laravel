<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Permiso;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        if (!checkPermiso('perfiles.is_read')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $perfiles = Perfil::all();
        return view('pages.perfiles.index', compact('perfiles'));
    }

    public function create()
    {
        if (!checkPermiso('perfiles.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        return view('pages.perfiles.create');
    }

    public function store(Request $request)
    {
        if (!checkPermiso('perfiles.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $request->validate([
            'nombre' => 'required|unique:perfiles,nombre',
            'descripcion' => 'nullable|string',
        ]);

        $request->merge([
            'nombre' => strtolower(trim($request->nombre))
        ]);
        
        Perfil::create($request->only('nombre', 'descripcion'));

        return redirect()->route('perfiles.index')->with('success', 'Perfil Actualizado.');
    }

    public function edit(Perfil $perfil)
    {
        if (!checkPermiso('perfiles.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $permisos = Permiso::all(); // <-- asegúrate de importar el modelo
        return view('pages.perfiles.edit', compact('perfil', 'permisos'));
    }

    public function update(Request $request, Perfil $perfil)
    {
        if (!checkPermiso('perfiles.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $request->merge([
            'nombre' => strtolower(trim($request->nombre))
        ]);

        $request->validate([
            'nombre' => 'required|unique:perfiles,nombre,' . $perfil->id,
            'descripcion' => 'nullable|string',
        ]);

        $perfil->update($request->only('nombre', 'descripcion'));

        $permisosInput = $request->input('permisos', []);
        $permisosData = [];

        foreach ($permisosInput as $permisoId => $acciones) {
            $permisosData[$permisoId] = [
                'is_read'       => isset($acciones['is_read']),
                'is_create'      => isset($acciones['is_create']),
                'is_update' => isset($acciones['is_update']),
                'is_delete'   => isset($acciones['is_delete']),
            ];
        }

        $perfil->permisos()->sync($permisosData);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy(Perfil $perfil)
    {
        if (!checkPermiso('perfiles.is_delete')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $perfil->delete();
        return redirect()->route('perfiles.index')->with('success', 'Perfil eliminado.');
    }
}
