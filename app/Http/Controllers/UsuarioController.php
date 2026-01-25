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
        if (!checkPermiso('usuarios.is_read')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $usuarios = User::all();
        return view('pages.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        if (!checkPermiso('usuarios.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        return view('pages.usuarios.create');
    }

    public function store(Request $request)
    {
        if (!checkPermiso('usuarios.is_create')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
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
        if (!checkPermiso('usuarios.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $perfiles = Perfil::all();
        return view('pages.usuarios.edit', compact('usuario', 'perfiles'));
    }

    public function update(Request $request, User $usuario)
    {
        if (!checkPermiso('usuarios.is_update')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
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
        if (!checkPermiso('administrador.is_delete')) {
           return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
