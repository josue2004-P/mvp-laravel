@extends('layouts.app')

@section('title', 'Crear Analisis')

@section('content')

<x-common.component-card title="Formulario Analisis" desc="Completa la información para registrar un Analisi." class="max-w-5xl">
    <form id="form-analisis" action="{{ route('analisis.store') }}" method="POST" class="md:grid grid-cols-1 md:grid-cols-2 gap-5">
    @csrf
        <!-- Cliente -->
        <div>
            <x-form.input-label for="idCliente" :value="__('Cliente')" required/>
            <x-form.input-select name="idCliente" 
            :messages="$errors->get('idCliente')"
            class="select2"
            >
                <option value="">Selecciona un cliente</option>
                @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ old('idCliente') == $c->id ? 'selected' : '' }}>
                        {{ $c->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
        </div>
        
        <!-- Doctor -->
        <div>
            <x-form.input-label for="idDoctor" :value="__('Doctor')" required/>
            <x-form.input-select name="idDoctor" 
            :messages="$errors->get('idDoctor')"
            class="select2"
            >
                <option value="">Selecciona un doctor</option>
                @foreach($doctores as $d)
                    <option value="{{ $d->id }}" {{ old('idDoctor') == $d->id ? 'selected' : '' }}>
                        {{ $d->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
        </div>

        <!-- Estatus -->
        <div class="space-y-1">
            <x-form.input-label for="estatusId" :value="__('Estatus')" required/>
            
            <div class="relative">
                {{-- El select se mantiene con su nombre original para que se envíe el dato --}}
                <x-form.input-select 
                    name="estatusId" 
                    id="estatusId"
                    :messages="$errors->get('estatusId')"
                    {{-- Clases para simular readonly y evitar interacción --}}
                    class="select2 pointer-events-none bg-gray-100 dark:bg-gray-800 opacity-70"
                    tabindex="-1"
                >
                    <option value="">Selecciona un estatus</option>
                    @foreach($estatusAnalisis as $value)
                        <option value="{{ $value->id }}" 
                            @selected(old('estatusId', $estatusInicialId) == $value->id)>
                            {{ $value->descripcion }}
                        </option>
                    @endforeach
                </x-form.input-select>
                
                {{-- Overlay transparente para bloquear clics si Select2 no respeta pointer-events --}}
                <div class="absolute inset-0 z-10 cursor-not-allowed"></div>
            </div>

            <p class="mt-1 text-[10px] text-blue-500 font-semibold uppercase italic dark:text-blue-400">
                <i class="fas fa-info-circle mr-1"></i> Estatus inicial bloqueado por configuración
            </p>
        </div>
        
        <!-- Tipo de Análisis -->
        <div>
            <x-form.input-label for="idTipoAnalisis" :value="__('Tipo de Análisis')" required/>
            <x-form.input-select name="idTipoAnalisis" 
            :messages="$errors->get('idTipoAnalisis')"
            class="select2"
            >
                <option value="">Selecciona un tipo</option>
                @foreach($tiposAnalisis as $t)
                    <option value="{{ $t->id }}" {{ old('idTipoAnalisis') == $t->id ? 'selected' : '' }}>
                        {{ $t->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
        </div>

        <!-- Método -->
        <div >
            <x-form.input-label for="idTipoMetodo" :value="__('Tipo de Método')" required/>
            <x-form.input-select name="idTipoMetodo"
                :messages="$errors->get('idTipoMetodo')"
                class="select2"
                >
                <option value="">Selecciona un tipo</option>
                @foreach($tiposMetodo as $tm)
                    <option value="{{ $tm->id }}" {{ old('idTipoMetodo') == $tm->id ? 'selected' : '' }}>
                        {{ $tm->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
        </div>


        <!-- Muestra -->
        <div >
            <x-form.input-label for="idTipoMuestra" :value="__('Tipo de Muestra')" required/>
            <x-form.input-select name="idTipoMuestra" 
                :messages="$errors->get('idTipoMuestra')"
                class="select2"
                >
                <option value="">Selecciona una muestra</option>
                @foreach($tiposMuestra as $tm)
                    <option value="{{ $tm->id }}" {{ old('idTipoMuestra') == $tm->id ? 'selected' : '' }}>
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
                :value="old('nota')"
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
                <x-ui.button size="sm" type="submit" form="form-analisis">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </form>
</x-common.component-card>
@endsection