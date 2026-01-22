@extends('layouts.app')

@section('title', 'Nuevo Estatus de Análisis')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ 
    colorT: '{{ old('colorTexto', '#000000') }}',
    colorF: '{{ old('colorFondo', '#FFFFFF') }}'
}">
    <div class="mb-8 flex items-center gap-4">
        <div class="h-14 w-14 rounded-3xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-500/20 transition-transform hover:scale-105">
            <i class="fa-solid fa-plus text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Nuevo Estatus</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Define una nueva etiqueta visual y sus reglas lógicas para el laboratorio.</p>
        </div>
    </div>

    <form id="form-estatus-analisis" action="{{ route('estatus-analisis.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7 space-y-6">
                <x-common.component-card title="Configuración del Estatus" desc="Define el nombre y comportamiento del análisis.">
                    <div class="space-y-6">
                        {{-- Nombre --}}
                        <div>
                            <x-form.input-label for="nombre" :value="__('Nombre')" required/>
                            <x-form.text-input
                                name="nombre"
                                id="nombre"
                                x-model="texto"
                                placeholder="Ej. Validado, Pendiente..."
                                class="w-full font-bold text-lg"
                                :messages="$errors->get('nombre')"
                            />    
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <x-form.input-label for="descripcion" :value="__('Descripción')" />
                            <x-form.text-input
                                name="descripcion"
                                id="descripcion"
                                :value="old('descripcion')"
                                placeholder="Escribe la descripción del estatus"
                                class="w-full"
                                :messages="$errors->get('descripcion')"
                            />    
                        </div>

                        {{-- Reglas de Estado --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                            <label class="relative flex items-center p-4 rounded-2xl border border-gray-100 dark:border-gray-800 cursor-pointer hover:bg-indigo-50/50 transition-all group shadow-sm">
                                <input type="checkbox" name="analsisAbierto" value="1" {{ old('analsisAbierto') == '1' ? 'checked' : '' }}
                                    class="h-5 w-5 rounded-lg border-gray-300 text-indigo-600">
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">Análisis Abierto</span>
                                    <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-wider italic">Permite Edición</span>
                                </div>
                            </label>

                            <label class="relative flex items-center p-4 rounded-2xl border border-gray-100 dark:border-gray-800 cursor-pointer hover:bg-red-50/50 transition-all group shadow-sm">
                                <input type="checkbox" name="analisisCerrado" value="1" {{ old('analisisCerrado') == '1' ? 'checked' : '' }}
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

            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Apariencia Visual" desc="Previsualiza cómo se verá la etiqueta.">
                    {{-- Preview Dinámico --}}
                    {{-- <div class="mb-8 p-6 rounded-3xl bg-gray-50 dark:bg-white/[0.02] border border-gray-100 dark:border-gray-800 flex flex-col items-center text-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Vista Previa</span>
                        <div class="flex justify-center items-center w-full h-24 bg-white dark:bg-gray-900 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                            <span 
                                class="px-5 py-2 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg transition-all transform duration-300"
                                :style="{ color: colorT, backgroundColor: colorF, border: `1.5px solid ${colorT}30` }"
                                x-text="texto">
                            </span>
                        </div>
                    </div> --}}

                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 group hover:border-indigo-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <x-form.input-label for="colorTexto" :value="__('Color de Texto')" class="!mb-0 font-bold" />
                            </div>
                            <div class="w-44">
                                <x-form.color-input 
                                    name="colorTexto" 
                                    color="{{ old('colorTexto', '#000000') }}" 
                                    x-model="colorT"
                                    @input="colorT = $event.target.value"
                                />    
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 group hover:border-indigo-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <x-form.input-label for="colorFondo" :value="__('Color de Fondo')" class="!mb-0 font-bold" />
                            </div>
                            <div class="w-44">
                                <x-form.color-input 
                                    name="colorFondo" 
                                    color="{{ old('colorFondo', '#FFFFFF') }}" 
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
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Estatus
                            </x-ui.button>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>
        </div>
    </form>
</div>
@endsection