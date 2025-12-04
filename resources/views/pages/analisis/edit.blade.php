<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Análisis</h2>
    </x-slot>

    <form action="{{ route('analisis.update', $analisi) }}" method="POST">
    @csrf
    @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6 max-w-6xl">
            <!-- Formulario (columna principal) -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">

                    <!-- Cliente -->
                    <div class="mb-3">
                        <label>Cliente</label>
                        <select name="idCliente" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                            <option value="">Selecciona un cliente</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" {{ old('idCliente', $analisi->idCliente) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                        @error('idCliente')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Doctor -->
                    <div class="mb-3">
                        <label>Doctor</label>
                        <select name="idDoctor" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                            <option value="">Selecciona un doctor</option>
                            @foreach($doctores as $d)
                                <option value="{{ $d->id }}" {{ old('idDoctor', $analisi->idDoctor) == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                            @endforeach
                        </select>
                        @error('idDoctor')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tipo de Análisis -->
                    <div class="mb-3">
                        <label>Tipo de Análisis</label>
                        <select name="idTipoAnalisis" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposAnalisis as $t)
                                <option value="{{ $t->id }}" {{ old('idTipoAnalisis', $analisi->idTipoAnalisis) == $t->id ? 'selected' : '' }}>{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                        @error('idTipoAnalisis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Método -->
                    <div class="mb-3">
                        <label>Método</label>
                        <select name="idTipoMetodo" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                            <option value="">Selecciona un método</option>
                            @foreach($tiposMetodo as $m)
                                <option value="{{ $m->id }}" {{ old('idTipoMetodo', $analisi->idTipoMetodo) == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                        @error('idTipoMetodo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Muestra -->
                    <div class="mb-3">
                        <label>Muestra</label>
                        <select name="idTipoMuestra" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                            <option value="">Selecciona una muestra</option>
                            @foreach($tiposMuestra as $mu)
                                <option value="{{ $mu->id }}" {{ old('idTipoMuestra', $analisi->idTipoMuestra) == $mu->id ? 'selected' : '' }}>{{ $mu->nombre }}</option>
                            @endforeach
                        </select>
                        @error('idTipoMuestra')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Nota -->
                    <div class="mb-3">
                        <label>Nota</label>
                        <textarea name="nota" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring">{{ old('nota', $analisi->nota) }}</textarea>
                        @error('nota')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end items-center space-x-4 mt-4">
                        <a href="{{ route('analisis.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                        
                        <a href="{{ route('analisis.pdf', $analisi->id) }}" 
                        target="_blank"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Descargar PDF
                        </a>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Actualizar
                        </button>
                    </div>

            </div>

            <!-- Cuadro de categorías y hemogramas (derecha) -->
            <div class="lg:w-[33rem] bg-white shadow-lg rounded-lg p-4 overflow-auto max-h-[600px]">
                <h3 class="text-lg font-semibold mb-3">Categorías y Hemogramas</h3>

                @php
                    $hemogramasPorCategoria = $analisi->tipoAnalisis
                        ->hemogramas
                        ->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría');
                @endphp

                @foreach($hemogramasPorCategoria as $categoria => $hemogramas)
                    <div class="mb-4 border rounded">
                        <!-- Nombre de la categoría -->
                        <div class="bg-gray-100 px-3 py-2 font-semibold cursor-pointer hover:bg-gray-200">
                            {{ $categoria }}
                        </div>

                        <!-- Hemogramas con input de resultado -->
                        <div class="p-3 space-y-2">
                            @foreach($hemogramas as $hemograma)
                                @php
                                    $valorPrevio = $analisi->hemogramas->firstWhere('id', $hemograma->id)?->pivot->resultado;
                                @endphp

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between border p-2 rounded bg-white">
                                    <span class="mb-1 md:mb-0 w-[15rem]">{{ $hemograma->nombre }}</span>
                                    <input type="text" 
                                        name="resultados[{{ $hemograma->id }}]" 
                                        value="{{ old('resultados.'.$hemograma->id, $valorPrevio) }}"
                                        placeholder="Resultado"
                                        class="border px-2 py-1 rounded w-full md:w-1/2 focus:outline-none focus:ring">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </form>
</x-app-layout>
