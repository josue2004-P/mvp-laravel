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

        $configuracionPerfiles = \DB::table('configuracion_perfil_estatus_analisis')->get();

        $configuracionExistente = \DB::table('configuracion_analisis')
            ->where('id', 1)
            ->first(); 

        $flujosActuales = \DB::table('configuracion_flujo_estatus_analisis')
            ->where('configuracionEstatusId', 1)
            ->get()
            ->groupBy('estatusId')
            ->map(fn($group) => $group->pluck('siguienteEstatusId')->toArray())
            ->toArray();

        return view('pages.configuracion-analisis.index', compact('perfiles', 'estatus', 'configuracionExistente','configuracionPerfiles','flujosActuales'));
    }

    public function store(Request $request)
    {
        try {
            \DB::transaction(function () use ($request) {
                $configuracionId = 1; // ID de tu configuración global
                $usuarioId = auth()->id();

                // --- SECCIÓN 1: ACTUALIZAR ESTATUS INICIAL ---
                $configGeneral = \App\Models\ConfiguracionAnalisis::updateOrCreate(
                    ['id' => $configuracionId],
                    [
                        'inicialEstatusId' => $request->inicialEstatusId,
                        'usuarioIdActualizacion'   => $usuarioId,
                    ]
                );

                // --- SECCIÓN 2: LIMPIAR Y GUARDAR FLUJOS (TU PREGUNTA) ---
                // Eliminamos TODO lo anterior para este ID. Si el usuario desmarcó todo, 
                // la tabla quedará vacía para este análisis.
                \DB::table('configuracion_flujo_estatus_analisis')
                    ->where('configuracionEstatusId', $configuracionId)
                    ->delete();

                $flujos = $request->input('flujo') ?? [];
                $dataFlujo = [];

                foreach ($flujos as $origenId => $destinos) {
                    foreach ($destinos as $destinoId) {
                        $dataFlujo[] = [
                            'configuracionEstatusId' => $configuracionId,
                            'estatusId'              => $origenId,
                            'siguienteEstatusId'     => $destinoId,
                            'usuarioIdCreacion'      => $usuarioId,
                            'fechaCreacion'          => now(),
                        ];
                    }
                }

                if (!empty($dataFlujo)) {
                    \DB::table('configuracion_flujo_estatus_analisis')->insert($dataFlujo);
                }

                // --- SECCIÓN 3: LIMPIAR Y GUARDAR PERMISOS PERFILES ---
                \DB::table('configuracion_perfil_estatus_analisis')
                    ->where('configuracionAnalisisId', $configuracionId)
                    ->delete();

                $permisos = $request->input('permisos') ?? [];
                $dataPermisos = [];

                foreach ($permisos as $perfilId => $estatusArray) {
                    foreach ($estatusArray as $estatusId => $opciones) {
                        // Solo insertamos si al menos una opción (modificar o automático) está marcada
                        if (isset($opciones['modificar']) || isset($opciones['automatico'])) {
                            $dataPermisos[] = [
                                'configuracionAnalisisId' => $configuracionId,
                                'perfilId'                => $perfilId,
                                'estatusId'               => $estatusId,
                                'modificar'               => isset($opciones['modificar']) ? 1 : 0,
                                'automatico'              => isset($opciones['automatico']) ? 1 : 0,
                                'usuarioIdCreacion'       => $usuarioId,
                                'fechaCreacion'           => now(),
                            ];
                        }
                    }
                }

                if (!empty($dataPermisos)) {
                    \DB::table('configuracion_perfil_estatus_analisis')->insert($dataPermisos);
                }
            });

            return redirect()->back()->with('success', 'Configuración de análisis actualizada con éxito.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar la configuración: ' . $e->getMessage());
        }
    }
}
