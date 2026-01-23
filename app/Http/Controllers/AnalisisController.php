<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Cliente;
use App\Models\Doctor;
use App\Models\TipoAnalisis;
use App\Models\TipoMetodo;
use App\Models\TipoMuestra;
use App\Models\ConfiguracionAnalisis;
use App\Models\EstatusAnalisis;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

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
        $estatusAnalisis = EstatusAnalisis::all();

        $configuracion = ConfiguracionAnalisis::find(1);
        $estatusInicialId = $configuracion ? $configuracion->inicial_estatus_id : null;

        return view('pages.analisis.create', compact(
            'clientes', 
            'doctores', 
            'tiposAnalisis', 
            'tiposMetodo', 
            'tiposMuestra', 
            'estatusInicialId',
            'estatusAnalisis'
        ));
    }

    public function store(Request $request)
    {
        // Ahora los nombres coinciden 100% con tu base de datos
        $validated = $request->validate([
            'cliente_id'          => 'required|exists:clientes,id',
            'doctor_id'           => 'required|exists:doctores,id',
            'estatus_id'          => 'required|exists:estatus_analisis,id',
            'tipo_analisis_id'    => 'required|exists:tipo_analisis,id',
            'tipo_metodo_id'  => 'sometimes|nullable|exists:tipo_metodos,id',
            'tipo_muestra_id' => 'sometimes|nullable|exists:tipo_muestras,id',
            'nota'                => 'nullable|string|max:255',
        ]);

        try {
            // Agregamos el ID del usuario directamente al array validado
            $validated['usuario_creacion_id'] = auth()->id();

            \App\Models\Analisis::create($validated);

            return redirect()->route('analisis.index')
                ->with('success', 'Análisis registrado exitosamente.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al registrar el análisis: ' . $e->getMessage());
        }
    }

    public function edit(Analisis $analisi)
    {
        // Cargamos la relación con la tabla pivote y sus resultados
        $analisi->load('hemogramas');

        $clientes        = Cliente::all();
        $doctores        = Doctor::all();
        $tiposAnalisis   = TipoAnalisis::with('parametrosHemograma')->get();
        $tiposMetodo     = TipoMetodo::all();
        $tiposMuestra    = TipoMuestra::all();
        $estatusAnalisis = EstatusAnalisis::all();

        // Detectamos el estatus actual dinámicamente desde el modelo
        $estatusActualId = $analisi->estatus_id; 
        $configuracionId = 1; // ID global de configuración
        $slugPermisoMaestro = 'mod-est-anl';
        $misPerfilesIds = auth()->user()->perfiles->pluck('id')->toArray();

        // 1. Verificamos si el usuario tiene el permiso maestro para mover estatus
        $tienePermisoMaestro = auth()->user()->perfiles()
            ->whereHas('permisos', fn($q) => $q->where('nombre', $slugPermisoMaestro))
            ->exists();

        $estatusPermitidos = [];
    
        if ($tienePermisoMaestro) {
            // Obtenemos los estatus destino permitidos según el Flujo y los Permisos del Perfil
            $estatusPermitidos = \DB::table('configuracion_flujo_estatus_analisis as flujo')
                ->join('estatus_analisis as e', 'flujo.estatus_siguiente_id', '=', 'e.id')
                ->join('configuracion_perfil_estatus_analisis as p', function($join) use ($misPerfilesIds, $configuracionId) {
                    $join->on('e.id', '=', 'p.estatus_id')
                        ->whereIn('p.perfil_id', $misPerfilesIds)
                        ->where('p.configuracion_analisis_id', $configuracionId)
                        ->where('p.modificar', 1); // Solo estatus donde el perfil tenga check azul
                })
                ->where('flujo.configuracion_analisis_id', $configuracionId)
                ->where('flujo.estatus_id', $estatusActualId)
                ->select('e.id', 'e.nombre', 'e.descripcion') // Asegúrate de traer 'nombre' para la vista
                ->distinct()
                ->get();
        }

        // 2. Verificamos si el perfil del usuario permite modificar datos en el estatus ACTUAL
        $puedeModificarActual = \DB::table('configuracion_perfil_estatus_analisis')
            ->whereIn('perfil_id', $misPerfilesIds)
            ->where('estatus_id', $estatusActualId)
            ->where('modificar', 1)
            ->exists();

        return view('pages.analisis.edit', compact(
            'analisi',
            'clientes',
            'doctores',
            'tiposAnalisis',
            'tiposMetodo',
            'tiposMuestra',
            'estatusActualId', 
            'estatusPermitidos', 
            'puedeModificarActual',
            'tienePermisoMaestro',
            'estatusAnalisis'      
        ));
    }

public function update(Request $request, Analisis $analisi)
{
    $validated = $request->validate([
        'cliente_id'       => 'required|exists:clientes,id',
        'doctor_id'        => 'required|exists:doctores,id',
        'estatus_id'       => 'required|exists:estatus_analisis,id',
        'tipo_analisis_id' => 'required|exists:tipo_analisis,id',
        'tipo_muestra_id' => 'nullable|exists:tipo_muestras,id',
        'tipo_metodo_id' => 'nullable|exists:tipo_metodos,id',
        'nota'             => 'nullable|string|max:255',
        'resultados'       => 'nullable|array',
    ]);

    try {
        \DB::transaction(function () use ($request, $analisi, $validated) {
            // 1. Actualización de datos principales
            $analisi->update($validated);

            // 2. Sincronización de Resultados
            if ($request->has('resultados')) {
                $syncData = [];
                $userId = auth()->id();

                foreach ($request->resultados as $hemogramaId => $valor) {
                    // Solo agregamos al sync si el valor tiene contenido
                    // Si viene null, no lo metemos al array para que sync no lo borre
                    if (!is_null($valor) && $valor !== '') {
                        $syncData[$hemogramaId] = [
                            'resultado'                => $valor,
                            'usuario_actualizacion_id' => $userId,
                            'usuario_creacion_id'      => $userId 
                        ];
                    }
                }
                
                // IMPORTANTE: Si quieres mantener los resultados anteriores 
                // y solo actualizar/agregar los nuevos, usa syncWithoutDetaching
                if (!empty($syncData)) {
                    $analisi->hemogramas()->syncWithoutDetaching($syncData);
                }
            }
        });

        return redirect()->back()->with('success', 'Cambios guardados correctamente.');

    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Error al actualizar: ' . $e->getMessage());
    }
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
        $pdf = Pdf::loadView('pdf.pdf', compact('analisis'))
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

    public function exportPdf(Request $request)
    {
        // Capturamos los parámetros de la URL
        $search = $request->query('search');
        $limite = $request->query('perPage', 10); // 10 por defecto
        
        $doctorId = $request->query('doctorId');
        $tipoAnalisisId = $request->query('tipoAnalisisId');
        $tipoMuestraId = $request->query('tipoMuestraId');
        $tipoMetodoId = $request->query('tipoMetodoId');

        $query = Analisis::with(['cliente', 'doctor', 'tipoAnalisis', 'tipoMetodo', 'tipoMuestra', 'usuarioCreacion'])
            // Búsqueda por Cliente o por ID de análisis
            ->where(function ($q) use ($search) {
                if ($search) {
                    $q->whereHas('cliente', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%' . $search . '%');
                    })->orWhere('id', 'like', '%' . $search . '%');
                }
            })
            // Filtros dinámicos (se aplican solo si tienen valor)
            ->when($doctorId, fn($q) => $q->where('idDoctor', $doctorId))
            ->when($tipoAnalisisId, fn($q) => $q->where('idTipoAnalisis', $tipoAnalisisId))
            ->when($tipoMuestraId, fn($q) => $q->where('idTipoMuestra', $tipoMuestraId))
            ->when($tipoMetodoId, fn($q) => $q->where('idTipoMetodo', $tipoMetodoId));

        // Obtenemos los datos limitados por el valor del select de la tabla
        // Usamos ->get() porque el PDF requiere una colección, no un paginador
        $analisis = $query->latest()->limit($limite)->get(); 

        $pdf = Pdf::loadView('pdf.analisis', compact('analisis'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('reporte-analisis.pdf');
    }
}
