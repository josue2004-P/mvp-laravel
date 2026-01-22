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
        $validated = $request->validate([
            'nombre'                             => 'required|string|max:255',
            'categoria_hemograma_completo_id'    => 'required|exists:categoria_hemograma_completo,id',
            'unidad_id'                          => 'required|exists:unidades,id',
            'referencia'                         => 'nullable|string|max:255',
        ]);

        try {
            HemogramaCompleto::create($validated);

            return redirect()
                ->route('hemograma_completo.index')
                ->with('success', 'El parámetro "' . $request->nombre . '" ha sido configurado exitosamente.');

        } catch (\Exception $e) {
            \Log::error("Error al crear hemograma_completo: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al intentar guardar el parámetro.');
        }
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
        $validated = $request->validate([
            'nombre'                             => 'required|string|max:255',
            'categoria_hemograma_completo_id'    => 'required|exists:categoria_hemograma_completo,id',
            'unidad_id'                          => 'required|exists:unidades,id',
            'referencia'                         => 'nullable|string|max:255',
        ]);

        try {
            $hemogramaCompleto->update($validated);

            return redirect()
                ->route('hemograma_completo.index')
                ->with('success', 'La configuración del parámetro se actualizó correctamente.');

        } catch (\Exception $e) {
            \Log::error("Error al actualizar hemograma_completo ID {$hemogramaCompleto->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'No se pudieron procesar los cambios.');
        }
    }

    public function destroy(HemogramaCompleto $hemogramaCompleto)
    {
        $hemogramaCompleto->delete();
        return redirect()->route('hemograma_completo.index')->with('success', 'Hemograma eliminado correctamente');
    }
}
