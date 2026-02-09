<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $perfiles = Perfil::all();
        return view('pages.usuarios.create', compact('perfiles'));
    }

    public function store(Request $request)
    {
        if (!checkPermiso('usuarios.is_create')) {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }

        $validated = $request->validate([
            'usuario'           => ['required', 'string', 'max:255', 'unique:users'],
            'name'              => ['required', 'string', 'max:255'],
            'apellido_paterno'  => ['required', 'string', 'max:255'],
            'apellido_materno'  => ['nullable', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'foto'              => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'firma'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'perfiles'          => ['nullable', 'array'],
            'perfiles.*'        => ['exists:perfiles,id'],
        ]);

        $fotoPath = $request->file('foto') 
            ? $request->file('foto')->store('usuarios/fotos', 'public') 
            : null;

        $firmaPath = $request->file('firma') 
            ? $request->file('firma')->store('usuarios/firmas', 'public') 
            : null;

        $user = User::create([
            'usuario'           => strtoupper($validated['usuario']), // Normalización de ID
            'name'              => $validated['name'],
            'apellido_paterno'  => $validated['apellido_paterno'],
            'apellido_materno'  => $validated['apellido_materno'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'is_activo'         => true, 
            'foto'              => $fotoPath,
            'firma'             => $firmaPath,
        ]);

        if ($request->has('perfiles')) {
            $user->perfiles()->attach($validated['perfiles']);
        }

        return redirect()->route('usuarios.index')
            ->with('success', 'Expediente de usuario consolidado correctamente.');
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
        // 1. Verificación de Seguridad
        if (!checkPermiso('usuarios.is_update')) {
            return redirect()->back()->with('error', 'No tienes permisos para realizar esta acción');
        }

        // 2. Validación Técnica
        $validated = $request->validate([
            'usuario'           => 'required|string|max:255|unique:users,usuario,' . $usuario->id,
            'name'              => 'required|string|max:255',
            'apellido_paterno'  => 'required|string|max:255',
            'apellido_materno'  => 'nullable|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'password'          => 'nullable|string|min:8|confirmed', 
            'is_activo'         => 'nullable|boolean',
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'firma'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            'perfiles'          => 'nullable|array',
            'perfiles.*'        => 'exists:perfiles,id'
        ]);

        try {
            // 3. Preparación de Datos Base
            $data = [
                'usuario'           => strtoupper($validated['usuario']),
                'name'              => $validated['name'],
                'apellido_paterno'  => $validated['apellido_paterno'],
                'apellido_materno'  => $validated['apellido_materno'],
                'email'             => $validated['email'],
                'is_activo'         => $request->boolean('is_activo'),
            ];

            // 4. Gestión de Seguridad (Password)
            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            // 5. Gestión de Multimedia (Foto)
            if ($request->hasFile('foto')) {
                if ($usuario->foto) {
                    Storage::disk('public')->delete($usuario->foto);
                }
                $data['foto'] = $request->file('foto')->store('usuarios/fotos', 'public');
            }

            // 6. Gestión de Multimedia (Firma)
            if ($request->hasFile('firma')) {
                if ($usuario->firma) {
                    Storage::disk('public')->delete($usuario->firma);
                }
                $data['firma'] = $request->file('firma')->store('usuarios/firmas', 'public');
            }

            // 7. Ejecución de Persistencia y Sincronización
            $usuario->update($data);
            $usuario->perfiles()->sync($request->input('perfiles', []));

            return redirect()
                ->route('usuarios.index')
                ->with('success', "El expediente de {$usuario->name} ha sido actualizado correctamente.");

        } catch (\Exception $e) {
            // Registramos el error completo en el log para auditoría
            \Log::error("Fallo de integridad en actualización de usuario ID {$usuario->id}: " . $e->getMessage());

            // Retornamos con el mensaje de error real para que aparezca en tu alerta
            return back()
                ->withInput()
                ->with('error', 'Error del sistema: ' . $e->getMessage());
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
