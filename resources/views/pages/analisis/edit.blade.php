@extends('layouts.app')

@section('title', 'Editar Analisis')

@section('content')

<x-common.component-card title="Informacion General" desc="Informacion General del Analisis" class="max-w-7xl">
    <form id="form-analisis" action="{{ route('analisis.update', $analisi) }}" method="POST" class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    @csrf
    @method('PUT')
 
        <x-common.component-card title="Datos Generales" desc="Datos Generales del Analisis" class="col-span-2">

            <!-- Cliente -->
            <div>
                <x-form.input-label for="idCliente" :value="__('Cliente')" required/>
                <x-form.input-select name="idCliente" :messages="$errors->get('idCliente')">
                    <option value="">Selecciona un cliente</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}" {{ old('idCliente', $analisi->idCliente) == $c->id ? 'selected' : '' }}>
                            {{ $c->nombre }}
                        </option>
                    @endforeach
                </x-form.input-select>
            </div>
            
            <!-- Doctor -->
            <div>
                <x-form.input-label for="idDoctor" :value="__('Doctor')" required/>
                <x-form.input-select name="idDoctor" :messages="$errors->get('idDoctor')">
                    <option value="">Selecciona un doctor</option>
                    @foreach($doctores as $d)
                        <option value="{{ $d->id }}" {{ old('idDoctor', $analisi->idDoctor) == $d->id ? 'selected' : '' }}>
                            {{ $d->nombre }}
                        </option>
                    @endforeach
                </x-form.input-select>
            </div>

            <!-- Tipo de Análisis -->
            <div>
                <x-form.input-label for="idTipoAnalisis" :value="__('Tipo de Análisis')" required/>
                <x-form.input-select name="idTipoAnalisis" :messages="$errors->get('idTipoAnalisis')">
                    <option value="">Selecciona un tipo</option>
                    @foreach($tiposAnalisis as $t)
                        <option value="{{ $t->id }}" {{  old('idTipoAnalisis', $analisi->idTipoAnalisis) == $t->id ? 'selected' : '' }}>
                            {{ $t->nombre }}
                        </option>
                    @endforeach
                </x-form.input-select>
            </div>

            <!-- Método -->
            <div >
                <x-form.input-label for="idTipoMetodo" :value="__('Tipo de Método')" required/>
                <x-form.input-select name="idTipoMetodo" :messages="$errors->get('idTipoMetodo')">
                    <option value="">Selecciona un tipo</option>
                    @foreach($tiposMetodo as $tm)
                        <option value="{{ $tm->id }}" {{ old('idTipoMetodo', $analisi->idTipoMetodo) == $tm->id ? 'selected' : '' }}>
                            {{ $tm->nombre }}
                        </option>
                    @endforeach
                </x-form.input-select>
            </div>
            
            <!-- Muestra -->
            <div >
                <x-form.input-label for="idTipoMuestra" :value="__('Tipo de Muestra')" required/>
                <x-form.input-select name="idTipoMuestra" :messages="$errors->get('idTipoMuestra')">
                    <option value="">Selecciona una muestra</option>
                    @foreach($tiposMuestra as $tm)
                        <option value="{{ $tm->id }}" {{ old('idTipoMuestra', $analisi->idTipoMuestra) == $tm->id ? 'selected' : '' }}>
                            {{ $tm->nombre }}
                        </option>
                    @endforeach
                </x-form.input-select>
            </div>

            <div class="col-span-2">
                <x-form.input-label for="nota" :value="__('Nota')"/>
                <x-form.text-input
                    type="text"
                    name="nota"
                    placeholder="Escribe la nota"
                    :value="old('nota', $analisi->nota)"
                    :messages="$errors->get('nota')"
                />    
                <x-input-error :messages="$errors->get('nota')" class="mt-2" />
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('analisis.index') }}"
                        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <a href="{{ route('analisis.pdf', $analisi->id) }}" target="_blank" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">Descargar PDF</a>

                    <x-ui.button size="sm" type="submit" form="form-analisis">
                        Guardar
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>

        <x-common.component-card title="Hemogramas Completos" desc="Ingresa el resultado del analisis" class="">

                @php
                    $hemogramasPorCategoria = $analisi->tipoAnalisis
                        ->hemogramas
                        ->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría');
                @endphp

                @foreach($hemogramasPorCategoria as $categoria => $hemogramas)
                    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <!-- Nombre de la categoría -->
                        <div class=" px-5 py-2 cursor-pointer text-base font-medium text-gray-800 dark:text-white/90 ">{{ $categoria }}</div>

                        <!-- Hemogramas con input de resultado -->
                        <div class="p-3 space-y-2">
                            @foreach($hemogramas as $hemograma)
                                @php
                                    $valorPrevio = $analisi->hemogramas->firstWhere('id', $hemograma->id)?->pivot->resultado;
                                @endphp

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between  p-2  rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                                    <span class="mb-1 md:mb-0 mr-4 text-xs font-medium text-gray-800 dark:text-white/90 ">{{ $hemograma->nombre }}</span>
                                    <input type="text" 
                                           name="resultados[{{ $hemograma->id }}]" 
                                           value="{{ old('resultados.'.$hemograma->id, $valorPrevio) }}"
                                           placeholder="Resultado"
                                           class="border px-2 py-1 rounded w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-indigo-400     
                                                text-gray-800 
                                                shadow-theme-xs
                                                border-gray-300
                                                 placeholder:text-gray-400
                                                dark:border-gray-700
                                                dark:bg-gray-900
                                                dark:text-white/90 dark:placeholder:text-white/30
                                        ">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

        </x-common.component-card>

    </form>
</x-common.component-card>
@endsection