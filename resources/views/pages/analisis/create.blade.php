@extends('layouts.app')

@section('title', 'Nuevo Análisis')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="mb-8 flex items-center gap-4 text-white">
        <div class="h-14 w-14 rounded-3xl bg-indigo-600 flex items-center justify-center shadow-xl shadow-indigo-500/20">
            <i class="fa-solid fa-file-medical text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Registro de Análisis</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Nombres de campos sincronizados con la base de datos.</p>
        </div>
    </div>

    <form id="form-analisis" action="{{ route('analisis.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Columna Izquierda --}}
            <div class="lg:col-span-7 space-y-6">
                <x-common.component-card title="Información General" desc="Selección de cliente y médico.">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-2">
                        <div class="col-span-2">
                            <x-form.input-label for="cliente_id" :value="__('Cliente')" required/>
                            <x-form.input-select name="cliente_id" id="cliente_id" class="select2">
                                <option value="">Selecciona un cliente</option>
                                @foreach($clientes as $c)
                                    <option value="{{ $c->id }}" @selected(old('cliente_id') == $c->id)>{{ $c->getNombreCompletoAttribute() }}</option>
                                @endforeach
                            </x-form.input-select>
                            <x-form.input-error :messages="$errors->get('cliente_id')" class="mt-2" />

                        </div>
                        
                        <div class="col-span-2">
                            <x-form.input-label for="doctor_id" :value="__('Doctor Solicitante')" required/>
                            <x-form.input-select name="doctor_id" id="doctor_id" class="select2">
                                <option value="">Selecciona un doctor</option>
                                @foreach($doctores as $d)
                                    <option value="{{ $d->id }}" @selected(old('doctor_id') == $d->id)>{{ $d->getNombreCompletoAttribute() }}</option>
                                @endforeach
                            </x-form.input-select>
                            <x-form.input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <div class="col-span-2 bg-gray-50 dark:bg-white/[0.02] p-5 rounded-2xl border border-dashed border-gray-200 dark:border-gray-800">
                            <x-form.input-label :value="__('Estatus Inicial')" class="text-indigo-600 dark:text-indigo-400" />
                            <div class="flex items-center gap-4 mt-2">
                                <input type="hidden" name="estatus_id" value="{{ $estatusInicialId }}">
                                @php $estatusActual = $estatusAnalisis->find($estatusInicialId); @endphp
                                @if($estatusActual)
                                    <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest" 
                                          style="background-color: {{ $estatusActual->color_fondo }}; color: {{ $estatusActual->color_texto }}">
                                        {{ $estatusActual->nombre }}
                                    </span>
                                    @endif
                                    
                                    <p class="text-[10px] text-gray-400 font-bold uppercase italic"><i class="fa-solid fa-lock mr-1"></i> Predefinido</p>
                                    <x-form.input-error :messages="$errors->get('estatus_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </x-common.component-card>
            </div>

            {{-- Columna Derecha --}}
            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Especificaciones Técnicas" desc="Categorización del estudio.">
                    <div class="space-y-4 py-2">
                        <div>
                            <x-form.input-label for="tipo_analisis_id" :value="__('Tipo de Análisis')" required/>
                            <x-form.input-select name="tipo_analisis_id" id="tipo_analisis_id" class="select2">
                                <option value="">Selecciona un tipo</option>
                                @foreach($tiposAnalisis as $t)
                                    <option value="{{ $t->id }}" @selected(old('tipo_analisis_id') == $t->id)>{{ $t->nombre }}</option>
                                @endforeach
                            </x-form.input-select>
                            <x-form.input-error :messages="$errors->get('tipo_analisis_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="tipo_metodo_id" :value="__('Tipo de Método')" required/>
                            <x-form.input-select name="tipo_metodo_id" id="tipo_metodo_id" class="select2">
                                <option value="">Selecciona un método</option>
                                @foreach($tiposMetodo as $tm)
                                    <option value="{{ $tm->id }}" @selected(old('tipo_metodo_id') == $tm->id)>{{ $tm->nombre }}</option>
                                @endforeach
                            </x-form.input-select>
                            <x-form.input-error :messages="$errors->get('tipo_metodo_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="tipo_muestra_id" :value="__('Tipo de Muestra')" required/>
                            <x-form.input-select name="tipo_muestra_id" id="tipo_muestra_id" class="select2">
                                <option value="">Selecciona una muestra</option>
                                @foreach($tiposMuestra as $tm)
                                    <option value="{{ $tm->id }}" @selected(old('tipo_muestra_id') == $tm->id)>{{ $tm->nombre }}</option>
                                @endforeach
                            </x-form.input-select>
                            <x-form.input-error :messages="$errors->get('tipo_muestra_id')" class="mt-2" />
                        </div>
                    </div>
                </x-common.component-card>
            </div>

            {{-- Notas --}}
            <div class="lg:col-span-12">
                <x-common.component-card>
                    <x-form.input-label for="nota" :value="__('Nota u Observaciones')" />
                    <x-form.text-input name="nota" id="nota" placeholder="Escribe aquí..." :value="old('nota')" />
                    
                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('analisis.index') }}" class="text-sm font-bold text-gray-400 hover:text-red-500">Cancelar</a>
                            <x-ui.button type="submit" class="px-8 shadow-xl shadow-indigo-500/20">
                                <i class="fa-solid fa-vial-circle-check mr-2"></i> Crear Análisis
                            </x-ui.button>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>
        </div>
    </form>
</div>
@endsection