<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstatusAnalisis;
use App\Models\ConfiguracionAnalisis;
use App\Models\Perfil;
use Illuminate\Support\Facades\DB;

class ConfiguracionAnalisisController extends Controller
{
    public function index()
    {
        // Perfiles con el permiso específico
        $perfiles = Perfil::whereHas('permisos', function ($q) {
            $q->where('nombre', 'mod-est-anl');
        })->get();
        
        // Estatus activos para el flujo
        $estatus = EstatusAnalisis::where('analisis_abierto', 1)
            ->orWhere('analisis_cerrado', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        // Cargar configuración global (ID 1)
        $configuracionExistente = ConfiguracionAnalisis::find(1);

        // Permisos de perfiles actuales
        $configuracionPerfiles = DB::table('configuracion_perfil_estatus_analisis')
            ->where('configuracion_analisis_id', 1)
            ->get();

        // Mapeo de flujos para la vista (Origen => [Destinos])
        $flujosActuales = DB::table('configuracion_flujo_estatus_analisis')
            ->where('configuracion_analisis_id', 1)
            ->get()
            ->groupBy('estatus_id')
            ->map(fn($group) => $group->pluck('estatus_siguiente_id')->toArray())
            ->toArray();

        return view('pages.configuracion-analisis.index', compact(
            'perfiles', 
            'estatus', 
            'configuracionExistente', 
            'configuracionPerfiles', 
            'flujosActuales'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inicialEstatusId' => 'required|integer|exists:estatus_analisis,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $configId = 1; 
                $userId = auth()->id();
                $now = now();

                // 1. Configuración General
                ConfiguracionAnalisis::updateOrCreate(
                    ['id' => $configId],
                    [
                        'inicial_estatus_id'       => $request->inicialEstatusId,
                        'usuario_creacion_id'      => $userId,
                        'usuario_actualizacion_id' => $userId,
                    ]
                );

                // 2. Flujo de Estatus (Sincronización)
                DB::table('configuracion_flujo_estatus_analisis')
                    ->where('configuracion_analisis_id', $configId)
                    ->delete();

                $flujos = $request->input('flujo', []);
                $dataFlujo = [];
                foreach ($flujos as $origenId => $destinos) {
                    foreach ($destinos as $destinoId) {
                        $dataFlujo[] = [
                            'configuracion_analisis_id' => $configId,
                            'estatus_id'                => $origenId,
                            'estatus_siguiente_id'      => $destinoId,
                            'usuario_creacion_id'       => $userId,
                            'usuario_actualizacion_id'  => $userId, // CAMPO FALTANTE AGREGADO
                            'created_at'                => $now,
                            'updated_at'                => $now,
                        ];
                    }
                }
                if (!empty($dataFlujo)) DB::table('configuracion_flujo_estatus_analisis')->insert($dataFlujo);

                // 3. Permisos por Perfil (Sincronización)
                DB::table('configuracion_perfil_estatus_analisis')
                    ->where('configuracion_analisis_id', $configId)
                    ->delete();

                $permisos = $request->input('permisos', []);
                $dataPermisos = [];
                foreach ($permisos as $perfilId => $estatusArray) {
                    foreach ($estatusArray as $estatusId => $opciones) {
                        if (isset($opciones['modificar']) || isset($opciones['automatico'])) {
                            $dataPermisos[] = [
                                'configuracion_analisis_id' => $configId,
                                'perfil_id'                 => $perfilId,
                                'estatus_id'                => $estatusId,
                                'modificar'                 => isset($opciones['modificar']) ? 1 : 0,
                                'automatico'                => isset($opciones['automatico']) ? 1 : 0,
                                'usuario_creacion_id'       => $userId,
                                'usuario_actualizacion_id'  => $userId, // CAMPO FALTANTE AGREGADO
                                'created_at'                => $now,
                                'updated_at'                => $now,
                            ];
                        }
                    }
                }
                if (!empty($dataPermisos)) DB::table('configuracion_perfil_estatus_analisis')->insert($dataPermisos);
            });

            return redirect()->back()->with('success', 'Configuración actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}