<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClienteController extends Controller
{
    // Listar clientes
    public function index()
    {
        // Después (paginación de 10 por página)
        $clientes = Cliente::when(request('search'), function($query) {
        $query->where('nombre', 'like', '%'.request('search').'%');
    })
    ->paginate(10); // <- importante

        return view('pages.clientes.index', compact('clientes'));
    }

    public function analisis(Cliente $cliente)
    {
        $analisis = $cliente->analisis()->latest()->paginate(10);
        
        // Obtenemos el último registro para la gráfica de hemograma
        $ultimoAnalisis = $cliente->analisis()->latest()->first();
        
        // Preparamos los datos (ajusta las llaves según tus columnas en la BD)
        $datosHemograma = [];
        $fechaUltimo = $ultimoAnalisis ? $ultimoAnalisis->created_at->format('d/m/Y') : 'Sin registro';

        if ($ultimoAnalisis) {
            $datosHemograma = [
                'Hemoglobina' => $ultimoAnalisis->hemoglobina ?? 0,
                'Leucocitos'  => $ultimoAnalisis->leucocitos ?? 0,
                'Plaquetas'   => $ultimoAnalisis->plaquetas ?? 0,
                'Eritrocitos' => $ultimoAnalisis->eritrocitos ?? 0,
            ];
        }

        return view('pages.clientes.analisis-index', compact('cliente', 'analisis', 'datosHemograma', 'fechaUltimo'));
    }

    // Formulario para crear cliente
    public function create()
    {
        return view('pages.clientes.create');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Datos Personales
            'nombre'           => 'required|string|max:255|unique:clientes,nombre',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'edad'             => 'required|integer|min:0|max:120',
            'fecha_nacimiento' => 'nullable|date',
            'sexo'             => 'required|in:MASCULINO,FEMENINO,OTRO',

            // Dirección
            'calle'            => 'nullable|string|max:255',
            'no_exterior'      => 'nullable|string|max:20',
            'no_interior'      => 'nullable|string|max:20',
            'colonia'          => 'nullable|string|max:255',
            'codigo_postal'    => 'nullable|string|max:10',
            'ciudad'           => 'nullable|string|max:100',
            'estado'           => 'nullable|string|max:100',
            
            // Otros
            'referencia'       => 'nullable|string',
            'is_activo'        => 'boolean',
        ]);

        try {
            Cliente::create($validated);

            return redirect()
                ->route('clientes.index')
                ->with('success', 'El cliente ' . $request->nombre . ' ha sido registrado exitosamente.');

        } catch (\Exception $e) {
            Log::error("Error al crear cliente: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar el cliente. Por favor, intente de nuevo.');
        }
    }

    // Mostrar cliente (opcional)
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    // Formulario para editar cliente
    public function edit(Cliente $cliente)
    {
        return view('pages.clientes.edit', compact('cliente'));
    }

    // Actualizar cliente
/**
     * Actualiza el cliente en la base de datos.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // 1. Validación con excepción de ID para el campo único
        $validated = $request->validate([
            'nombre'           => 'required|string|max:100|unique:clientes,nombre,' . $cliente->id,
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'email'            => 'nullable|email|max:150',
            'edad'             => 'required|integer|min:0|max:120',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'sexo'             => 'required|in:MASCULINO,FEMENINO,OTRO',
            
            // Dirección
            'calle'            => 'nullable|string|max:255',
            'no_exterior'      => 'nullable|string|max:20',
            'no_interior'      => 'nullable|string|max:20',
            'colonia'          => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|max:10',
            'ciudad'           => 'nullable|string|max:100',
            'estado'           => 'nullable|string|max:100',
            
            'referencia'       => 'nullable|string|max:500',
            'is_activo'        => 'required|boolean',
        ]);

        try {
            // 2. Actualización de los datos
            $cliente->update($validated);

            // 3. Redirección
            return redirect()
                ->route('clientes.index')
                ->with('success', 'Los datos de ' . $cliente->nombre . ' se actualizaron correctamente.');

        } catch (\Exception $e) {
            Log::error("Error actualizando cliente ID {$cliente->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'No se pudieron guardar los cambios. Intente de nuevo.');
        }
    }

    // Eliminar cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }


public function generarPdf($id)
{
    $cliente = Cliente::findOrFail($id);

    // Obtenemos todos los análisis del último al primero
    $analisisCollection = $cliente->analisis()
        ->with([
            'doctor', 
            'tipoAnalisis', 
            'hemogramas.categoria', 
            'hemogramas.unidad'
        ])
        ->latest() 
        ->get();

    if ($analisisCollection->isEmpty()) {
        return back()->with('error', 'El cliente no tiene análisis registrados.');
    }

    // El primer elemento de la colección es el último creado
    $ultimo = $analisisCollection->first();
    

    $pdf = Pdf::loadView('pdf.reporte_general', [
        'cliente' => $cliente,
        'analisisCollection' => $analisisCollection,
        'ultimo' => $ultimo,
        'fechaUltimo' => $ultimo->created_at->format('d/m/Y H:i'),
    ])
    ->setPaper('A4', 'portrait')
    ->setOptions(['isRemoteEnabled' => true]);

    return $pdf->stream('expediente_'.$cliente->id.'.pdf');
}
}
