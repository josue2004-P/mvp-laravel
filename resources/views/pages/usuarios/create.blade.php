<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Crear Usuario</h2>
    </x-slot>

    <form action="{{ route('usuarios.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label>Nombre</label>
            <input name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label>Email</label>
            <input name="email" type="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label>Contraseña</label>
            <input name="password" type="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label>Confirmar Contraseña</label>
            <input name="password_confirmation" type="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('usuarios.index') }}" class="ml-2 text-gray-600">Cancelar</a>
    </form>
</x-app-layout>
