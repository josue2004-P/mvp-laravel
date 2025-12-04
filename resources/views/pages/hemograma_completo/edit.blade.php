<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Hemograma Completo</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white rounded-lg shadow p-6">
        <form action="{{ route('hemograma_completo.update', $hemogramaCompleto) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $hemogramaCompleto->nombre) }}" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Categoría</label>
                <select name="idCategoriaHemogramaCompleto" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" {{ old('idCategoriaHemogramaCompleto', $hemogramaCompleto->idCategoriaHemogramaCompleto) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
                @error('idCategoriaHemogramaCompleto')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Unidad</label>
                <select name="idUnidad" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona una unidad</option>
                    @foreach($unidades as $u)
                        <option value="{{ $u->id }}" {{ old('idUnidad', $hemogramaCompleto->idUnidad) == $u->id ? 'selected' : '' }}>{{ $u->nombre }}</option>
                    @endforeach
                </select>
                @error('idUnidad')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

 
            <div class="mb-3">
                <label>Referencia</label>
                <input type="text" name="referencia" value="{{ old('referencia', $hemogramaCompleto->referencia) }}" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                @error('referencia')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Actualizar</button>
            <a href="{{ route('hemograma_completo.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
