<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Nuevo Permiso</h2>
    </x-slot>

    <form action="{{ route('permisos.store') }}" method="POST" class="max-w-lg mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mt-6">
        @csrf

        <!-- Header interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Crear Nuevo Permiso</h1>
            <p class="text-gray-500 text-sm mt-2">Ingresa los datos del permiso y guarda para continuar.</p>
        </div>

        <!-- Nombre -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
            <input type="text" name="nombre"
                class="w-full rounded-lg border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                required>
            @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Descripción -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
            <textarea name="descripcion" rows="3"
                class="w-full rounded-lg border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
            @error('descripcion')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('permisos.index') }}"
                class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </a>
            <button type="submit"
                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-500 text-white rounded-lg font-semibold shadow-md hover:from-blue-700 hover:to-indigo-600 transition">
                Guardar
            </button>
        </div>
    </form>
</x-app-layout>
