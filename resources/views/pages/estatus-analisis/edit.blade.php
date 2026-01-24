@extends('layouts.app')

@section('title', 'Editar Estatus de Análisis')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ 
    texto: '{{ old('nombreCorto', $estatus->nombre) }}',
    colorT: '{{ old('colorTexto', $estatus->color_texto ?? '#000000') }}',
    colorF: '{{ old('colorFondo', $estatus->color_fondo ?? '#FFFFFF') }}'
}">
    {{-- Header con Identidad --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-14 w-14 rounded-3xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-500/20 transition-transform hover:scale-105">
            <i class="fa-solid fa-pen-to-square text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Editar Estatus</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Actualiza la apariencia y reglas lógicas del flujo de laboratorio.</p>
        </div>
    </div>

    <form id="form-estatus-analisis" action="{{ route('estatus-analisis.update', $estatus->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Columna Izquierda: Identidad y Reglas --}}
            <div class="lg:col-span-7 space-y-6">
                <x-common.component-card title="Configuración del Estatus" desc="Ajusta el nombre y comportamiento del análisis.">
                    <div class="space-y-6">
                        {{-- Nombre --}}
                        <div>
                            <x-form.input-label for="nombreCorto" :value="__('Nombre Corto')" required/>
                            <x-form.text-input
                                name="nombreCorto"
                                id="nombreCorto"
                                x-model="texto"
                                class="w-full font-bold text-lg"
                                :messages="$errors->get('nombreCorto')"
                            />    
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <x-form.input-label for="descripcion" :value="__('Descripción')" />
                            <x-form.textarea-input 
                                name="descripcion" 
                                id="descripcion" 
                                rows="4" 
                                placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                            >
                                {{ old('descripcion', $estatus->descripcion) }}
                            </x-form.textarea-input>
                        </div>

                        {{-- Reglas de Estado (Checkboxes como Tarjetas) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            {{-- Checkbox Independiente: Abierto --}}
                            <label class="relative flex items-center p-4 rounded-2xl border border-gray-100 dark:border-gray-800 cursor-pointer hover:bg-indigo-50/50 transition-all group">
                                <input type="checkbox" 
                                    name="analsisAbierto" 
                                    value="1" 
                                    {{ old('analsisAbierto', $estatus->analisis_abierto) == 1 ? 'checked' : '' }}
                                    class="h-5 w-5 rounded-lg border-gray-300 text-indigo-600">
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">Análisis Abierto</span>
                                    <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-wider italic">Permite Edición</span>
                                </div>
                            </label>

                            {{-- Checkbox Independiente: Cerrado --}}
                            <label class="relative flex items-center p-4 rounded-2xl border border-gray-100 dark:border-gray-800 cursor-pointer hover:bg-red-50/50 transition-all group">
                                <input type="checkbox" 
                                    name="analisisCerrado" 
                                    value="1" 
                                    {{ old('analisisCerrado', $estatus->analisis_cerrado) == 1 ? 'checked' : '' }}
                                    class="h-5 w-5 rounded-lg border-gray-300 text-red-600">
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">Análisis Cerrado</span>
                                    <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-wider italic">Bloquea Edición</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </x-common.component-card>
            </div>

            {{-- Columna Derecha: Apariencia --}}
            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Apariencia Visual" desc="Previsualiza cómo se verá la etiqueta.">
                    
                    {{-- Preview Dinámico --}}
                    {{-- <div class="mb-8 p-6 rounded-3xl bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 flex flex-col items-center text-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Vista Previa Actual</span>
                        <div class="flex justify-center items-center w-full h-24 bg-white dark:bg-gray-900 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                            <span 
                                class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg transition-all transform duration-300"
                                :style="{ color: colorT, backgroundColor: colorF, border: `1.5px solid ${colorT}30` }"
                                x-text="texto">
                            </span>
                        </div>
                    </div> --}}

                    {{-- Inputs de Color --}}
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 group hover:border-indigo-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <x-form.input-label for="colorTexto" :value="__('Color de Texto')" class="!mb-0 font-bold" />
                            </div>
                            <div class="w-40">
                                <x-form.color-input 
                                    name="colorTexto" 
                                    color="{{ old('colorTexto', $estatus->color_texto ?? '#000000') }}" 
                                    x-model="colorT"
                                    @input="colorT = $event.target.value"
                                />    
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 group hover:border-indigo-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <x-form.input-label for="colorFondo" :value="__('Color de Fondo')" class="!mb-0 font-bold" />
                            </div>
                            <div class="w-40">
                                <x-form.color-input 
                                    name="colorFondo" 
                                    color="{{ old('colorFondo', $estatus->color_fondo ?? '#FFFFFF') }}" 
                                    x-model="colorF"
                                    @input="colorF = $event.target.value"
                                />    
                            </div>
                        </div>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('estatus-analisis.index') }}" class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark mr-1"></i> Cancelar
                            </a>
                            <x-ui.button size="sm" type="submit" form="form-estatus-analisis" class="shadow-xl shadow-indigo-500/20">
                                <i class="fa-solid fa-rotate mr-2"></i> Actualizar Estatus
                            </x-ui.button>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>
        </div>
    </form>
</div>
@endsection