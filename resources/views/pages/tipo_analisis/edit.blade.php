<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Editar Tipo de Análisis</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-10">

        <!-- Encabezado interno -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Editar Tipo de Análisis</h1>
            <p class="text-gray-500 text-sm mt-2">Modifica el nombre y selecciona los hemogramas correspondientes a este tipo de análisis.</p>
        </div>

        <form action="{{ route('tipo_analisis.update', $tipoAnalisis) }}" method="POST" x-data="{ abierto: {} }" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Tipo de Análisis</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🧪</span>
                    <input type="text" name="nombre" 
                           value="{{ old('nombre', $tipoAnalisis->nombre) }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Ej. Análisis Clínico" required>
                </div>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Categorías -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Hemogramas por Categoría</h3>
                @foreach($hemogramas->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría') as $categoria => $hemos)
                    <div class="mb-4 border rounded-lg overflow-hidden">
                        <!-- Botón categoría -->
                        <div class="bg-gray-100 px-4 py-3 cursor-pointer flex justify-between items-center hover:bg-gray-200 transition"
                             @click="abierto['{{ $categoria }}'] = !abierto['{{ $categoria }}']">
                            <span class="font-semibold text-gray-700">{{ $categoria }}</span>
                            <span x-text="abierto['{{ $categoria }}'] ? '−' : '+'"
                                  class="font-bold text-gray-600"></span>
                        </div>

                        <!-- Hemogramas -->
                        <div x-show="abierto['{{ $categoria }}']" x-transition class="p-4 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($hemos as $hemograma)
                                    <label class="flex items-center p-3 border rounded-lg bg-white shadow-sm hover:bg-gray-100 cursor-pointer">
                                        <input type="checkbox" name="hemogramas[]" value="{{ $hemograma->id }}"
                                               {{ in_array($hemograma->id, $tipoAnalisis->hemogramas->pluck('id')->toArray()) ? 'checked' : '' }}
                                               class="form-checkbox h-5 w-5 text-indigo-600 mr-3">
                                        <span class="text-gray-700">{{ $hemograma->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4 pt-6">
                <a href="{{ route('tipo_analisis.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                    Actualizar Tipo de Análisis
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
