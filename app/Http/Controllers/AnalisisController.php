<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Cliente;
use App\Models\Doctor;
use App\Models\TipoAnalisis;
use App\Models\TipoMetodo;
use App\Models\TipoMuestra;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Importar la clase

class AnalisisController extends Controller
{
    public function index()
    {
        $analisis = Analisis::with(['cliente','doctor','tipoAnalisis','tipoMetodo','tipoMuestra','usuarioCreacion'])->get();
        return view('pages.analisis.index', compact('analisis'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $doctores = Doctor::all();
        $tiposAnalisis = TipoAnalisis::all();
        $tiposMetodo = TipoMetodo::all();
        $tiposMuestra = TipoMuestra::all();

        return view('pages.analisis.create', compact('clientes','doctores','tiposAnalisis','tiposMetodo','tiposMuestra'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idCliente' => 'required|exists:clientes,id',
            'idDoctor' => 'required|exists:doctores,id',
            'idTipoAnalisis' => 'required|exists:tipo_analisis,id',
            'idTipoMetodo' => 'required|exists:tipo_metodos,id',
            'idTipoMuestra' => 'required|exists:tipo_muestras,id',
            'nota' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['idUsuarioCreacion'] = auth()->id();

        Analisis::create($data);

        return redirect()->route('analisis.index')->with('success', 'Análisis creado correctamente');
    }

    public function edit(Analisis $analisi)
    {
        // Precarga los hemogramas ya ligados a este análisis
        $analisi->load('hemogramas');

        // Trae también las relaciones necesarias para pintar categorías y hemogramas
        $clientes      = Cliente::all();
        $doctores      = Doctor::all();
        $tiposAnalisis = TipoAnalisis::with('hemogramas.categoria')->get();
        $tiposMetodo   = TipoMetodo::all();
        $tiposMuestra  = TipoMuestra::all();

        return view('pages.analisis.edit', compact(
            'analisi',
            'clientes',
            'doctores',
            'tiposAnalisis',
            'tiposMetodo',
            'tiposMuestra'
        ));
    }


    public function update(Request $request, Analisis $analisi)
    {
        $validated = $request->validate([
            'idCliente'      => 'required|exists:clientes,id',
            'idDoctor'       => 'required|exists:doctores,id',
            'idTipoAnalisis' => 'required|exists:tipo_analisis,id',
            'idTipoMetodo'   => 'required|exists:tipo_metodos,id',
            'idTipoMuestra'  => 'required|exists:tipo_muestras,id',
            'nota'           => 'nullable|string',
            'resultados'     => 'nullable|array',
            'resultados.*'   => 'nullable|string|max:100',
        ]);

        // Actualizar datos del análisis
        $analisi->update($validated);

        // Guardar resultados de hemogramas
        if (!empty($validated['resultados'])) {
            $pivotData = [];
            foreach ($validated['resultados'] as $idHemograma => $resultado) {
                if (trim((string) $resultado) !== '') {
                    $pivotData[$idHemograma] = ['resultado' => $resultado];
                }
            }
            $analisi->hemogramas()->syncWithoutDetaching($pivotData);
        }

        return redirect()
            ->route('analisis.edit', $analisi->id)
            ->with('success', 'Análisis actualizado correctamente');
    }



    public function destroy(Analisis $analisi)
    {
        $analisi->delete();
        return redirect()->route('analisis.index')->with('success', 'Análisis eliminado correctamente');
    }


    public function generarPdf(Analisis $analisis)
    {
        // Cargar relaciones
        $analisis->load(['cliente', 'doctor', 'tipoAnalisis', 'tipoMetodo', 'tipoMuestra', 'hemogramas.categoria']);

        // Generar PDF desde la vista sin márgenes
        $pdf = Pdf::loadView('pages.analisis.pdf', compact('analisis'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true, // <--- esto es clave
                    'margin_top' => 0,
                    'margin_bottom' => 0,
                    'margin_left' => 0,
                    'margin_right' => 0,
                ]);

        // Descargar el PDF
        return $pdf->stream('analisis_'.$analisis->id.'.pdf');
    }

}
