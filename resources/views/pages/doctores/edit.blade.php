<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Doctor</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white rounded-lg shadow p-6">
        <form action="{{ route('doctores.update', $doctor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $doctor->nombre) }}" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Activo</label>
                <select name="activo" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring">
                    <option value="1" {{ $doctor->activo ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$doctor->activo ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Actualizar</button>
            <a href="{{ route('doctores.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
