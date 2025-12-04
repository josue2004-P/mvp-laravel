<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Método</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white rounded-lg shadow p-6">
        <form action="{{ route('tipo_metodo.update', $tipoMetodo) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $tipoMetodo->nombre) }}" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Actualizar</button>
            <a href="{{ route('tipo_metodo.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
