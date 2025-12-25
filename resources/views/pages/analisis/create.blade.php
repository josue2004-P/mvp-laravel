@extends('layouts.app')

@section('title', 'Crear Analisis')

@section('content')

    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200">
            <!-- Título del formulario -->
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-extrabold text-indigo-700">Registrar Análisis</h1>
                <p class="text-gray-500 text-sm mt-2">Completa la información del análisis para continuar.</p>
            </div>

            <form action="{{ route('analisis.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf

                <!-- Cliente -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Cliente</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">👤</span>
                        <select name="idCliente" class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="">Selecciona un cliente</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" {{ old('idCliente') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('idCliente')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Doctor -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Doctor</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🩺</span>
                        <select name="idDoctor" class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="">Selecciona un doctor</option>
                            @foreach($doctores as $d)
                                <option value="{{ $d->id }}" {{ old('idDoctor') == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('idDoctor')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Tipo de Análisis -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tipo de Análisis</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔬</span>
                        <select name="idTipoAnalisis" class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposAnalisis as $t)
                                <option value="{{ $t->id }}" {{ old('idTipoAnalisis') == $t->id ? 'selected' : '' }}>{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('idTipoAnalisis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Método -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Método</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">⚙️</span>
                        <select name="idTipoMetodo" class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="">Selecciona un método</option>
                            @foreach($tiposMetodo as $m)
                                <option value="{{ $m->id }}" {{ old('idTipoMetodo') == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('idTipoMetodo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Muestra -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Muestra</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🧪</span>
                        <select name="idTipoMuestra" class="w-full pl-10 border border-gray-300 rounded-lg px-8 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                            <option value="">Selecciona una muestra</option>
                            @foreach($tiposMuestra as $mu)
                                <option value="{{ $mu->id }}" {{ old('idTipoMuestra') == $mu->id ? 'selected' : '' }}>{{ $mu->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('idTipoMuestra')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Nota (en ancho completo) -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Nota</label>
                    <textarea name="nota" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Escribe alguna nota">{{ old('nota') }}</textarea>
                    @error('nota')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Botones (en ancho completo) -->
                <div class="md:col-span-2 flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('analisis.index') }}" 
                       class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-blue-600 transition">
                        Guardar Análisis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection