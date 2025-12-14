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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado.');
    }

    public function edit(User $usuario)
    {
        $perfiles = Perfil::all();
        return view('pages.usuarios.edit', compact('usuario', 'perfiles'));
    }

    public function update(Request $request, User $usuario)
    {
        $usuario->update($request->only('name', 'email'));

        // Sincronizar perfiles
        $usuario->perfiles()->sync($request->input('perfiles', []));

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
