<?php

namespace App\Http\Controllers;

use App\Models\HemogramaCompleto;
use App\Models\CategoriaHemogramaCompleto;
use App\Models\Unidad;
use App\Models\TipoAnalisis;
use Illuminate\Http\Request;

class HemogramaCompletoController extends Controller
{
    public function index(Request $request)
    {
        $query = HemogramaCompleto::query()->with(['categoria', 'unidad']);

        // FILTRADO
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nombre', 'like', "%{$search}%")
                ->orWhereHas('categoria', fn($q) => $q->where('nombre', 'like', "%{$search}%"))
                ->orWhereHas('unidad', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
        }

        // PAGINACIÓN
        $hemogramas = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('pages.hemograma_completo.index', compact('hemogramas'));
    }

    public function create()
    {
        $categorias = CategoriaHemogramaCompleto::all();
        $unidades = Unidad::all();
        $tiposAnalisis = TipoAnalisis::all();

        return view('pages.hemograma_completo.create', compact('categorias', 'unidades', 'tiposAnalisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'idCategoriaHemogramaCompleto' => 'required|exists:categoria_hemograma_completo,id',
            'idUnidad' => 'required|exists:unidades,id',
            'referencia' => 'required|string|max:100',
        ]);

        HemogramaCompleto::create($request->all());

        return redirect()->route('hemograma_completo.index')->with('success', 'Hemograma creado correctamente');
    }

    public function edit(HemogramaCompleto $hemogramaCompleto)
    {
        $categorias = CategoriaHemogramaCompleto::all();
        $unidades = Unidad::all();
        $tiposAnalisis = TipoAnalisis::all();

        return view('pages.hemograma_completo.edit', compact('hemogramaCompleto', 'categorias', 'unidades', 'tiposAnalisis'));
    }

    public function update(Request $request, HemogramaCompleto $hemogramaCompleto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'idCategoriaHemogramaCompleto' => 'required|exists:categoria_hemograma_completo,id',
            'idUnidad' => 'required|exists:unidades,id',
            'referencia' => 'required|string|max:100',
        ]);

        $hemogramaCompleto->update($request->all());

        return redirect()->route('hemograma_completo.index')->with('success', 'Hemograma actualizado correctamente');
    }

    public function destroy(HemogramaCompleto $hemogramaCompleto)
    {
        $hemogramaCompleto->delete();
        return redirect()->route('hemograma_completo.index')->with('success', 'Hemograma eliminado correctamente');
    }
}
