<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Permiso</h2>
    </x-slot>

    <form action="{{ route('permisos.update', $permiso) }}" method="POST" class="max-w-lg">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block">Nombre</label>
            <input type="text" name="nombre" value="{{ $permiso->nombre }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block">Descripción</label>
            <textarea name="descripcion" class="w-full border rounded px-3 py-2">{{ $permiso->descripcion }}</textarea>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('permisos.index') }}" class="ml-2  text-gray-600">Cancelar</a>
    </form>
</x-app-layout>
