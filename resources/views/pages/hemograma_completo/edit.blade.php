@extends('layouts.app')

@section('title', 'Editar Parámetro')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Configuración</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Ajustando el parámetro: <span class="font-bold text-red-600 dark:text-red-400">{{ $hemogramaCompleto->nombre }}</span>
        </p>
    </div>

    <form id="form-hemogramas" action="{{ route('hemograma_completo.update', $hemogramaCompleto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card title="Actualizar Parámetros" desc="Ten cuidado: los cambios en los valores de referencia afectarán la interpretación de nuevos estudios." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Nombre --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="nombre" :value="__('Nombre del Parámetro')" required/>
                    <x-form.text-input
                        name="nombre"
                        class="w-full mt-1 font-bold text-red-700 dark:text-red-400"
                        :value="old('nombre', $hemogramaCompleto->nombre)"
                    />
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Categoría --}}
                <div>
                    <x-form.input-label for="categoria_hemograma_completo_id" :value="__('Categoría Hematológica')" required/>
                    <x-form.input-select name="categoria_hemograma_completo_id" class="w-full mt-1 select2">
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}" {{ old('categoria_hemograma_completo_id', $hemogramaCompleto->categoria_hemograma_completo_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </x-form.input-select>
                </div>

                {{-- Unidad --}}
                <div>
                    <x-form.input-label for="unidad_id" :value="__('Unidad de Medida')" required/>
                    <x-form.input-select name="unidad_id" class="w-full mt-1 select2">
                        @foreach($unidades as $u)
                            <option value="{{ $u->id }}" {{ old('unidad_id', $hemogramaCompleto->unidad_id) == $u->id ? 'selected' : '' }}>
                                {{ $u->nombre }}
                            </option>
                        @endforeach
                    </x-form.input-select>
                </div>

                {{-- Clasificación de Medida (Nuevo) --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="tipo_valor" :value="__('Clasificación de Medida (Opcional)')" />
                    <x-form.input-select name="tipo_valor" class="w-full mt-1">
                        <option value="">Ninguno (Valor Único)</option>
                        <option value="diferencial" {{ old('tipo_valor', $hemogramaCompleto->tipo_valor) == 'diferencial' ? 'selected' : '' }}>DIFERENCIAL (%)</option>
                        <option value="absoluto" {{ old('tipo_valor', $hemogramaCompleto->tipo_valor) == 'absoluto' ? 'selected' : '' }}>ABSOLUTOS (mm³)</option>
                    </x-form.input-select>
                    <x-form.input-error :messages="$errors->get('tipo_valor')" class="mt-2" />
                </div>

                <hr class="col-span-1 md:col-span-2 border-gray-100 dark:border-gray-800">

                {{-- Referencia Estándar --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="referencia" :value="__('Rango de Referencia Estándar')" />
                    <x-form.text-input
                        name="referencia"
                        class="w-full mt-1 font-mono text-indigo-600 dark:text-indigo-400"
                        :value="old('referencia', $hemogramaCompleto->referencia)"
                    />
                </div>

                {{-- Sección: Niveles de Riesgo Escalonados (Nuevo) --}}
                <div class="col-span-1 md:col-span-2 bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-layer-group text-indigo-500"></i>
                        <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Configuración de Niveles (Lípidos/Riesgo)</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-form.input-label for="rango_ideal" :value="__('Nivel Ideal')" />
                            <x-form.text-input 
                                name="rango_ideal" 
                                class="w-full mt-1 !border-green-200 dark:!border-green-900/30" 
                                :value="old('rango_ideal', $hemogramaCompleto->rango_ideal)" 
                            />
                        </div>
                        <div>
                            <x-form.input-label for="rango_moderado" :value="__('Nivel Moderado')" />
                            <x-form.text-input 
                                name="rango_moderado" 
                                class="w-full mt-1 !border-yellow-200 dark:!border-yellow-900/30" 
                                :value="old('rango_moderado', $hemogramaCompleto->rango_moderado)" 
                            />
                        </div>
                        <div>
                            <x-form.input-label for="rango_alto" :value="__('Nivel Alto / Riesgo')" />
                            <x-form.text-input 
                                name="rango_alto" 
                                class="w-full mt-1 !border-red-200 dark:!border-red-900/30" 
                                :value="old('rango_alto', $hemogramaCompleto->rango_alto)" 
                            />
                        </div>
                    </div>
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('hemograma_completo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar cambios
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-hemogramas">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Parámetro
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection