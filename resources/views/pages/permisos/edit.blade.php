<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Permiso</h2>
    </x-slot>

    <form action="{{ route('permisos.update', $permiso) }}" method="POST" class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mt-6">
        @csrf
        @method('PUT')

        <!-- Header interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Editar Permiso</h1>
            <p class="text-gray-500 text-sm mt-2">Modifica los datos del permiso y guarda los cambios.</p>
        </div>

        <!-- Nombre -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $permiso->nombre) }}"
                class="w-full rounded-lg border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                required>
            @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" rows="3"
                class="w-full rounded-lg border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('descripcion', $permiso->descripcion) }}</textarea>
            @error('descripcion')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('permisos.index') }}"
                class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </a>
            <button type="submit"
                class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                Actualizar
            </button>
        </div>
    </form>
</x-app-layout>
