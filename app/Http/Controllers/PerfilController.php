<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Permiso;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        $perfiles = Perfil::all();
        return view('pages.perfiles.index', compact('perfiles'));
    }

    public function create()
    {
        return view('pages.perfiles.create');
    }

    public function store(Request $request)
    {
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
        $permisos = Permiso::all(); // <-- asegúrate de importar el modelo
        return view('pages.perfiles.edit', compact('perfil', 'permisos'));
    }

    public function update(Request $request, Perfil $perfil)
    {
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
        $perfil->delete();
        return redirect()->route('perfiles.index')->with('success', 'Perfil eliminado.');
    }
}
