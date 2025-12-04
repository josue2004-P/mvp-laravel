<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

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

    // Formulario para crear cliente
    public function create()
    {
        return view('clientes.create');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:clientes,nombre',
            'edad'   => 'required|integer|min:0',
            'sexo'   => 'required|in:MASCULINO,FEMENINO',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    // Mostrar cliente (opcional)
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    // Formulario para editar cliente
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:clientes,nombre,' . $cliente->id,
            'edad'   => 'required|integer|min:0',
            'sexo'   => 'required|in:M,F',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    // Eliminar cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }
}
