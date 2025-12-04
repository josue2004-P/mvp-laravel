<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Cliente</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white rounded-lg shadow p-6">
        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ $cliente->nombre }}"  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400" required>
            </div>

            <div class="mb-3">
                <label>Edad</label>
                <input type="number" name="edad" value="{{ $cliente->edad }}"  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400"  required>
            </div>

            <div class="mb-3">
                <label>Sexo</label>
                <select name="sexo"  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400" required>
                    <option value="M" {{ $cliente->sexo == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ $cliente->sexo == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Activo</label>
                <select name="activo"  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-400" >
                    <option value="1" {{ $cliente->activo ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ !$cliente->activo ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Actualizar</button>
            <a href="{{ route('clientes.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>

</x-app-layout>

