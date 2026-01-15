<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EstatusAnalisis;
use App\Models\ConfiguracionAnalisis;
use App\Models\Perfil;

class ConfiguracionAnalisisController extends Controller
{
    public function index()
    {
        $perfiles = Perfil::whereHas('permisos', function ($q) {
            $q->where('nombre', 'mod-est-anl');
        })->get();
        
        $estatus = EstatusAnalisis::all();

        // Traemos la configuración actual y la indexamos por perfil y estatus para fácil acceso
        $configuracionExistente = \DB::table('configuracion_perfil_estatus_analisis')
            ->where('documentoTipo', 1)
            ->get()
            ->groupBy(['perfilId', 'estatusId']);

        return view('pages.configuracion-analisis.index', compact('perfiles', 'estatus', 'configuracionExistente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inicialEstatusId' => 'required|exists:estatus_analises,id',
        ]);

        ConfiguracionAnalisis::updateOrCreate(
            [
                'inicialEstatusId'       => $request->inicialEstatusId,
                'usuarioIdCreacion'      => auth()->id(),
                'usuarioIdActualizacion' => auth()->id(),
            ]
        );

        return redirect()->back()->with('success', 'Configuración general actualizada.');
    }
}
