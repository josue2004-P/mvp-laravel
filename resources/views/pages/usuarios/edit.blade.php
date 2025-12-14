@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST"  class="max-w-7xl mx-auto">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- Columna 1: Datos del Usuario --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <!-- Header interno -->
                <h3 class="text-xl font-semibold text-indigo-700 mb-6">Datos del Usuario</h3>
                <p class="text-gray-500 text-sm mb-6">Edita la información principal del usuario.</p>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700 mb-1">Nombre</label>
                    <input name="name" value="{{ $usuario->name }}" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2" required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Email</label>
                    <input name="email" value="{{ $usuario->email }}" type="email"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2" required>
                </div>

                <div class="flex justify-end mt-6 gap-4">
                    <a href="{{ route('usuarios.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold shadow-md hover:from-green-600 hover:to-emerald-700 transition">
                        Actualizar
                    </button>
                </div>
            </div>

            {{-- Columna 2-3: Perfiles asignados --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 h-fit">
                <!-- Header interno -->
                <h3 class="text-xl font-semibold text-indigo-700 mb-4">Perfiles Asignados</h3>
                <p class="text-gray-500 text-sm mb-4">Selecciona los perfiles que deseas asignar al usuario.</p>

                <div class="grid grid-cols-1 gap-4">
                    @foreach($perfiles as $perfil)
                        <label 
                        class="bg-indigo-50 border border-indigo-200 hover:border-indigo-400 transition-all duration-150 shadow-sm rounded-lg p-4 flex items-start gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="perfiles[]" 
                                value="{{ $perfil->id }}" 
                                {{ $usuario->perfiles->contains($perfil->id) ? 'checked' : '' }}
                                class="mt-1 accent-indigo-600"
                            >
                            <div>
                                <p class="font-medium text-indigo-800">{{ $perfil->nombre }}</p>
                                <p class="text-sm text-indigo-500">{{ $perfil->descripcion }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection
