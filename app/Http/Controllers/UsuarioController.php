<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('pages.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('pages.usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_activo' => 'nullable|boolean',
        ]);

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'is_activo' => $request->boolean('is_activo', true), // Default true si no viene
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario registrado con éxito.');
    }

    public function edit(User $usuario)
    {
        $perfiles = Perfil::all();
        return view('pages.usuarios.edit', compact('usuario', 'perfiles'));
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'is_activo' => 'nullable|boolean', // El checkbox envía true/null
            'perfiles'  => 'nullable|array',
            'perfiles.*'=> 'exists:perfiles,id'
        ]);

        try {
            $usuario->update([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'is_activo' => $request->boolean('is_activo'), 
            ]);

            $usuario->perfiles()->sync($request->input('perfiles', []));

            return redirect()
                ->route('usuarios.index')
                ->with('success', "El usuario {$usuario->name} ha sido actualizado con éxito.");

        } catch (\Exception $e) {
            \Log::error("Error al actualizar usuario ID {$usuario->id}: " . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al intentar guardar los cambios.');
        }
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
