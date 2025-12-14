@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

    <div class="max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-10">

        <!-- Encabezado interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Crear Usuario</h1>
            <p class="text-gray-500 text-sm mt-2">Completa los datos del usuario y guarda la información.</p>
        </div>

        <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">👤</span>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Nombre completo" required>
                </div>
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📧</span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="correo@ejemplo.com" required>
                </div>
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Contraseña -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔒</span>
                    <input type="password" name="password"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Contraseña" required>
                </div>
                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Contraseña</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔒</span>
                    <input type="password" name="password_confirmation"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Repite la contraseña" required>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('usuarios.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
@endsection
