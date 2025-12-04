<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Crear Cliente</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white rounded-lg shadow p-6">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
                <label class="block font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400" required >
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Edad -->
            <div class="mb-3">
                <label class="block font-medium">Edad</label>
                <input type="number" name="edad" value="{{ old('edad') }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400" required >
                @error('edad')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sexo -->
            <div class="mb-3">
                <label class="block font-medium">Sexo</label>
                <select name="sexo" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400" required >
                    <option value="">Seleccione...</option>
                    <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                    <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex items-center space-x-4 mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Guardar</button>
                <a href="{{ route('clientes.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

</x-app-layout>
