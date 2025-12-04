<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Tipo de Análisis</h2>
    </x-slot>

    <div class="max-w-4xl mt-6 bg-white rounded-lg shadow p-6">

        <form action="{{ route('tipo_analisis.update', $tipoAnalisis) }}" method="POST" x-data="{ abierto: {} }">
            @csrf
            @method('PUT')

            <!-- Input del nombre del tipo de análisis (siempre visible) -->
            <div class="mb-6">
                <label class="block font-semibold mb-1">Nombre del Tipo de Análisis</label>
                <input type="text" name="nombre" value="{{ old('nombre', $tipoAnalisis->nombre) }}" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Categorías como acordeón -->
            <div>
                <h3 class="text-lg font-semibold mb-3">Hemogramas por Categoría</h3>
                @foreach($hemogramas->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría') as $categoria => $hemos)
                    <div class="mb-4 border rounded">
                        <!-- Botón categoría -->
                        <div class="bg-gray-100 px-4 py-2 cursor-pointer flex justify-between items-center hover:bg-gray-200"
                             @click="abierto['{{ $categoria }}'] = !abierto['{{ $categoria }}']">
                            <span class="font-semibold">{{ $categoria }}</span>
                            <span x-text="abierto['{{ $categoria }}'] ? '-' : '+'"></span>
                        </div>

                        <!-- Hemogramas desplegables -->
                        <div x-show="abierto['{{ $categoria }}']" x-transition class="p-4 space-y-2 bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($hemos as $hemograma)
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-100 cursor-pointer">
                                        <input type="checkbox" name="hemogramas[]" value="{{ $hemograma->id }}"
                                            {{ in_array($hemograma->id, $tipoAnalisis->hemogramas->pluck('id')->toArray()) ? 'checked' : '' }}
                                            class="form-checkbox h-5 w-5 text-blue-600 mr-2">
                                        <span>{{ $hemograma->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Actualizar</button>
                <a href="{{ route('tipo_analisis.index') }}" class="text-gray-600 hover:underline ml-4">Cancelar</a>
            </div>
        </form>

    </div>
</x-app-layout>
