@extends('layouts.app')

@section('title', 'Editar Hemograma Completo')

@section('content')


    <div class="max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        
        <!-- Encabezado interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Editar Hemograma Completo</h1>
            <p class="text-gray-500 text-sm mt-2">Modifica los datos del hemograma completo y guarda los cambios.</p>
        </div>

        <form action="{{ route('hemograma_completo.update', $hemogramaCompleto) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📝</span>
                    <input type="text" name="nombre" value="{{ old('nombre', $hemogramaCompleto->nombre) }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Ej. Hemoglobina" required>
                </div>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Categoría -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Categoría</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📂</span>
                    <select name="idCategoriaHemogramaCompleto"
                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            required>
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}" {{ old('idCategoriaHemogramaCompleto', $hemogramaCompleto->idCategoriaHemogramaCompleto) == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('idCategoriaHemogramaCompleto')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Unidad -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Unidad</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">⚖️</span>
                    <select name="idUnidad"
                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            required>
                        <option value="">Selecciona una unidad</option>
                        @foreach($unidades as $u)
                            <option value="{{ $u->id }}" {{ old('idUnidad', $hemogramaCompleto->idUnidad) == $u->id ? 'selected' : '' }}>
                                {{ $u->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('idUnidad')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Referencia -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Referencia</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📏</span>
                    <input type="text" name="referencia" value="{{ old('referencia', $hemogramaCompleto->referencia) }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Ej. 13.5 - 17.5 g/dL" required>
                </div>
                @error('referencia')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('hemograma_completo.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                    Actualizar Hemograma
                </button>
            </div>
        </form>
    </div>
@endsection