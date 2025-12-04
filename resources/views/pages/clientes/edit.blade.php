<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Editar Cliente</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        
        <!-- Encabezado interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Editar Cliente</h1>
            <p class="text-gray-500 text-sm mt-2">Modifica los datos del cliente y guarda los cambios.</p>
        </div>

        <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">👤</span>
                    <input type="text" name="nombre" value="{{ $cliente->nombre }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Nombre del cliente" required>
                </div>
            </div>

            <!-- Edad -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Edad</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🎂</span>
                    <input type="number" name="edad" value="{{ $cliente->edad }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Edad del cliente" required>
                </div>
            </div>

            <!-- Sexo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sexo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">⚧️</span>
                    <select name="sexo"
                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            required>
                        <option value="MASCULINO" {{ $cliente->sexo == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                        <option value="FEMENINO" {{ $cliente->sexo == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
            </div>

            <!-- Activo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Activo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">✅</span>
                    <select name="activo"
                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="1" {{ $cliente->activo ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$cliente->activo ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('clientes.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                    Actualizar Cliente
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
