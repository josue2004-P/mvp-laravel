@extends('layouts.app')

@section('title', 'Configurar Parámetro de Hemograma')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Parámetro Hematológico</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Configura los elementos que componen el análisis de biometría hemática.</p>
    </div>

    <form id="form-hemogramas" action="{{ route('hemograma_completo.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Definición del Análisis" desc="Asigna el nombre técnico, su categoría y los valores de referencia." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="col-span-1 md:col-span-2 flex items-center gap-4 p-4 rounded-xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 mb-2">
                    <div class="h-12 w-12 rounded-lg bg-red-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-microscope text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-red-900 dark:text-red-400 uppercase tracking-tight">Módulo de Biometría Hemática</h4>
                        <p class="text-xs text-red-700 dark:text-red-500/80">Los parámetros configurados aquí aparecerán en la hoja de resultados del paciente.</p>
                    </div>
                </div> --}}

                {{-- Nombre del Parámetro --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="nombre" :value="__('Nombre del Parámetro')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Hemoglobina, Hematocrito, Plaquetas..."
                            class="w-full font-bold"
                            :value="old('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Categoría --}}
                <div class="col-span-1">
                    <x-form.input-label for="categoria_hemograma_completo_id" :value="__('Categoría Hematológica')" required/>
                    <div class="mt-1">
                        <x-form.input-select name="categoria_hemograma_completo_id" class="select2 w-full">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->id }}" {{ old('categoria_hemograma_completo_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </x-form.input-select>
                    </div>
                    <x-form.input-error :messages="$errors->get('categoria_hemograma_completo_id')" class="mt-2" />
                </div>

                {{-- Unidad de Medida --}}
                <div class="col-span-1">
                    <x-form.input-label for="unidad_id" :value="__('Unidad de Medida')" required/>
                    <div class="mt-1">
                        <x-form.input-select name="unidad_id" class="select2 w-full">
                            <option value="">Selecciona una unidad</option>
                            @foreach($unidades as $u)
                                <option value="{{ $u->id }}" {{ old('unidad_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->nombre }}
                                </option>
                            @endforeach
                        </x-form.input-select>
                    </div>
                    <x-form.input-error :messages="$errors->get('unidad_id')" class="mt-2" />
                </div>

                {{-- Rango de Referencia --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="referencia" :value="__('Valores de Referencia')" />
                    <div class="mt-1">
                        <x-form.text-input
                            id="referencia"
                            type="text"
                            name="referencia"
                            placeholder="Ej. Hombres: 13.5 - 17.5 / Mujeres: 12.0 - 15.5"
                            class="w-full font-mono text-indigo-600 dark:text-indigo-400"
                            :value="old('referencia')"
                        />
                    </div>
                    <p class="mt-1 text-[10px] text-gray-400 italic italic">Este texto se imprimirá tal cual en el reporte de resultados.</p>
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('hemograma_completo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al listado
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-hemogramas">
                        <i class="fa-solid fa-droplet mr-2"></i> Guardar Parámetro
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection