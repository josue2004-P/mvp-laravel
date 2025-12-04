<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Editar Método</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        
        <!-- Encabezado interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Editar Método</h1>
            <p class="text-gray-500 text-sm mt-2">Modifica los datos del método y guarda los cambios.</p>
        </div>

        <form action="{{ route('tipo_metodo.update', $tipoMetodo) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Método</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">⚙️</span>
                    <input type="text" name="nombre" value="{{ old('nombre', $tipoMetodo->nombre) }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Ej. Método Espectrofotométrico" required>
                </div>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('tipo_metodo.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                    Actualizar Método
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
