@extends('layouts.app')

@section('title', 'Editar Analisis')

@section('content')


    <div class="max-w-6xl mx-auto mt-8">
        <form action="{{ route('analisis.update', $analisi) }}" method="POST" class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            @csrf
            @method('PUT')

            <!-- Formulario principal (izquierda) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-200 space-y-5">
                <div class="mb-4 text-center">
                    <h1 class="text-2xl font-extrabold text-indigo-700">Formulario de Edición</h1>
                    <p class="text-gray-500 text-sm mt-1">Actualiza los datos del análisis y resultados de hemogramas.</p>
                </div>

                <!-- Cliente -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Cliente</label>
                    <select name="idCliente" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="">Selecciona un cliente</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ old('idCliente', $analisi->idCliente) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                    @error('idCliente')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Doctor -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Doctor</label>
                    <select name="idDoctor" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="">Selecciona un doctor</option>
                        @foreach($doctores as $d)
                            <option value="{{ $d->id }}" {{ old('idDoctor', $analisi->idDoctor) == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                        @endforeach
                    </select>
                    @error('idDoctor')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Tipo de Análisis -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tipo de Análisis</label>
                    <select name="idTipoAnalisis" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="">Selecciona un tipo</option>
                        @foreach($tiposAnalisis as $t)
                            <option value="{{ $t->id }}" {{ old('idTipoAnalisis', $analisi->idTipoAnalisis) == $t->id ? 'selected' : '' }}>{{ $t->nombre }}</option>
                        @endforeach
                    </select>
                    @error('idTipoAnalisis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Método -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Método</label>
                    <select name="idTipoMetodo" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="">Selecciona un método</option>
                        @foreach($tiposMetodo as $m)
                            <option value="{{ $m->id }}" {{ old('idTipoMetodo', $analisi->idTipoMetodo) == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                    @error('idTipoMetodo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Muestra -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Muestra</label>
                    <select name="idTipoMuestra" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                        <option value="">Selecciona una muestra</option>
                        @foreach($tiposMuestra as $mu)
                            <option value="{{ $mu->id }}" {{ old('idTipoMuestra', $analisi->idTipoMuestra) == $mu->id ? 'selected' : '' }}>{{ $mu->nombre }}</option>
                        @endforeach
                    </select>
                    @error('idTipoMuestra')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Nota -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nota</label>
                    <textarea name="nota" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('nota', $analisi->nota) }}</textarea>
                    @error('nota')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-end items-center space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('analisis.index') }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Cancelar</a>
                    <a href="{{ route('analisis.pdf', $analisi->id) }}" target="_blank" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">Descargar PDF</a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 text-white hover:from-indigo-700 hover:to-blue-600 transition">Actualizar</button>
                </div>
            </div>

            <!-- Cuadro de categorías y hemogramas (derecha) -->
            <div class="lg:col-span-1 bg-white shadow-lg rounded-2xl p-4 overflow-auto max-h-[600px] border border-gray-200">
                <h3 class="text-lg font-semibold mb-3">Categorías y Hemogramas</h3>

                @php
                    $hemogramasPorCategoria = $analisi->tipoAnalisis
                        ->hemogramas
                        ->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría');
                @endphp

                @foreach($hemogramasPorCategoria as $categoria => $hemogramas)
                    <div class="mb-4 border rounded">
                        <!-- Nombre de la categoría -->
                        <div class="bg-gray-100 px-3 py-2 font-semibold cursor-pointer hover:bg-gray-200">{{ $categoria }}</div>

                        <!-- Hemogramas con input de resultado -->
                        <div class="p-3 space-y-2">
                            @foreach($hemogramas as $hemograma)
                                @php
                                    $valorPrevio = $analisi->hemogramas->firstWhere('id', $hemograma->id)?->pivot->resultado;
                                @endphp

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between border p-2 rounded bg-white">
                                    <span class="mb-1 md:mb-0 w-[15rem] mr-4.">{{ $hemograma->nombre }}</span>
                                    <input type="text" 
                                           name="resultados[{{ $hemograma->id }}]" 
                                           value="{{ old('resultados.'.$hemograma->id, $valorPrevio) }}"
                                           placeholder="Resultado"
                                           class="border px-2 py-1 rounded w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
@endsection