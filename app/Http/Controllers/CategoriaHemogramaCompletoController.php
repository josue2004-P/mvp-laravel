<?php

namespace App\Http\Controllers;

use App\Models\CategoriaHemogramaCompleto;
use Illuminate\Http\Request;

class CategoriaHemogramaCompletoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaHemogramaCompleto::all();
        return view('pages.categoria_hemograma_completo.index', compact('categorias'));
    }

    public function create()
    {
        return view('pages.categoria_hemograma_completo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categoria_hemograma_completo,nombre',
        ]);

        CategoriaHemogramaCompleto::create($request->all());

        return redirect()->route('categoria_hemograma_completo.index')->with('success', 'Categoría creada correctamente');
    }

    public function edit(CategoriaHemogramaCompleto $categoriaHemogramaCompleto)
    {
        return view('pages.categoria_hemograma_completo.edit', compact('categoriaHemogramaCompleto'));
    }

    public function update(Request $request, CategoriaHemogramaCompleto $categoriaHemogramaCompleto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categoria_hemograma_completo,nombre,' . $categoriaHemogramaCompleto->id,
        ]);

        $categoriaHemogramaCompleto->update($request->all());

        return redirect()->route('categoria_hemograma_completo.index')->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(CategoriaHemogramaCompleto $categoriaHemogramaCompleto)
    {
        $categoriaHemogramaCompleto->delete();
        return redirect()->route('categoria_hemograma_completo.index')->with('success', 'Categoría eliminada correctamente');
    }
}
