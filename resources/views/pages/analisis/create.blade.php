<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Crear Análisis</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white rounded-lg shadow p-6">
        <form action="{{ route('analisis.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Cliente</label>
                <select name="idCliente" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona un cliente</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}" {{ old('idCliente') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
                @error('idCliente')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Doctor</label>
                <select name="idDoctor" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona un doctor</option>
                    @foreach($doctores as $d)
                        <option value="{{ $d->id }}" {{ old('idDoctor') == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                    @endforeach
                </select>
                @error('idDoctor')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Tipo de Análisis</label>
                <select name="idTipoAnalisis" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona un tipo</option>
                    @foreach($tiposAnalisis as $t)
                        <option value="{{ $t->id }}" {{ old('idTipoAnalisis') == $t->id ? 'selected' : '' }}>{{ $t->nombre }}</option>
                    @endforeach
                </select>
                @error('idTipoAnalisis')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Método</label>
                <select name="idTipoMetodo" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona un método</option>
                    @foreach($tiposMetodo as $m)
                        <option value="{{ $m->id }}" {{ old('idTipoMetodo') == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                    @endforeach
                </select>
                @error('idTipoMetodo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Muestra</label>
                <select name="idTipoMuestra" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring" required>
                    <option value="">Selecciona una muestra</option>
                    @foreach($tiposMuestra as $mu)
                        <option value="{{ $mu->id }}" {{ old('idTipoMuestra') == $mu->id ? 'selected' : '' }}>{{ $mu->nombre }}</option>
                    @endforeach
                </select>
                @error('idTipoMuestra')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-3">
                <label>Nota</label>
                <textarea name="nota" class="w-full border px-3 py-2 rounded focus:outline-none focus:ring">{{ old('nota') }}</textarea>
                @error('nota')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Guardar</button>
            <a href="{{ route('analisis.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
