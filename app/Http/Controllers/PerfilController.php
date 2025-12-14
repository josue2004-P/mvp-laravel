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
            'nombre' => 'required|unique:perfils,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Perfil::create($request->only('nombre', 'descripcion'));

        return redirect()->route('perfiles.index')->with('success', 'Perfil creado.');
    }

    public function edit(Perfil $perfil)
    {
        $permisos = Permiso::all(); // <-- asegúrate de importar el modelo
        return view('pages.perfiles.edit', compact('perfil', 'permisos'));
    }

    public function update(Request $request, Perfil $perfil)
    {
        $request->validate([
            'nombre' => 'required|unique:perfils,nombre,' . $perfil->id,
            'descripcion' => 'nullable|string',
        ]);

        $perfil->update($request->only('nombre', 'descripcion'));
        $perfil->permisos()->sync($request->input('permisos', []));
        
        return redirect()->route('perfiles.index')->with('success', 'Perfil actualizado.');
    }

    public function destroy(Perfil $perfil)
    {
        $perfil->delete();
        return redirect()->route('perfiles.index')->with('success', 'Perfil eliminado.');
    }
}
