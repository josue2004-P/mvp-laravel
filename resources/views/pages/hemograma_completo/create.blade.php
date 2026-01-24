@extends('layouts.app')

@section('title', 'Configurar Parámetro de Hemograma')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Parámetro Hematológico</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Configura biometrías hemáticas, diferenciales o perfiles lipídicos.</p>
    </div>

    <form id="form-hemogramas" action="{{ route('hemograma_completo.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Definición del Análisis" desc="Asigna el nombre técnico, su categoría y los valores de referencia." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Nombre del Parámetro --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="nombre" :value="__('Nombre del Parámetro')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Hemoglobina, Colesterol Total, Neutrófilos..."
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

                {{-- Clasificación (Imagen 2) --}}
                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="tipo_valor" :value="__('Clasificación de Medida (Opcional)')" />
                    <div class="mt-1">
                        <x-form.input-select name="tipo_valor" class="w-full">
                            <option value="">Ninguno (Valor Único)</option>
                            <option value="diferencial" {{ old('tipo_valor') == 'diferencial' ? 'selected' : '' }}>DIFERENCIAL (%)</option>
                            <option value="absoluto" {{ old('tipo_valor') == 'absoluto' ? 'selected' : '' }}>ABSOLUTOS (mm³)</option>
                        </x-form.input-select>
                    </div>
                </div>

                {{-- Rango de Referencia Estándar --}}
                <div class="col-span-1 md:col-span-2 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <x-form.input-label for="referencia" :value="__('Rango de Referencia Estándar')" />
                    <div class="mt-1">
                        <x-form.text-input
                            id="referencia"
                            type="text"
                            name="referencia"
                            placeholder="Ej. 5.0 - 10.0"
                            class="w-full font-mono text-indigo-600 dark:text-indigo-400"
                            :value="old('referencia')"
                        />
                    </div>
                </div>

                {{-- Sección: Niveles de Riesgo (Imagen 3) --}}
                <div class="col-span-1 md:col-span-2 bg-gray-50 dark:bg-gray-900/50 p-5 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group"></i> Rangos Escalonados (Opcional)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-form.input-label for="rango_ideal" :value="__('Nivel Ideal')" />
                            <x-form.text-input name="rango_ideal" class="w-full mt-1 border-green-200 dark:border-green-900/30" placeholder="Ej. < 200" :value="old('rango_ideal')" />
                        </div>
                        <div>
                            <x-form.input-label for="rango_moderado" :value="__('Nivel Moderado')" />
                            <x-form.text-input name="rango_moderado" class="w-full mt-1 border-yellow-200 dark:border-yellow-900/30" placeholder="Ej. 200 - 239" :value="old('rango_moderado')" />
                        </div>
                        <div>
                            <x-form.input-label for="rango_alto" :value="__('Nivel Alto')" />
                            <x-form.text-input name="rango_alto" class="w-full mt-1 border-red-200 dark:border-red-900/30" placeholder="Ej. > 240" :value="old('rango_alto')" />
                        </div>
                    </div>
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('hemograma_completo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver
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