@extends('layouts.app')

@section('title', 'Editar Categoría de Hemograma')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Categoría de Análisis</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Actualizando la categoría: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $categoriaHemogramaCompleto->nombre }}</span>
        </p>
    </div>

    <form id="form-categoria-hemograma" action="{{ route('categoria_hemograma_completo.update', $categoriaHemogramaCompleto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card title="Configuración de la Categoría" desc="Modifica los parámetros generales de esta clasificación de laboratorio." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="flex items-center gap-4 p-4 rounded-xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 mb-2">
                    <div class="h-12 w-12 rounded-lg bg-red-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-droplet text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-red-900 dark:text-red-400 uppercase tracking-tight">Módulo de Hematología</h4>
                        <p class="text-xs text-red-700 dark:text-red-500/80">Asegúrate de que el nombre sea descriptivo para los reportes de resultados.</p>
                    </div>
                </div> --}}

                {{-- Campo Nombre --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Categoría')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Serie Roja"
                            class="w-full font-semibold"
                            :value="old('nombre', $categoriaHemogramaCompleto->nombre)"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Campo Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción o Alcance')" />
                    <div class="mt-1">
                        <x-form.textarea-input 
                            name="descripcion" 
                            id="descripcion" 
                            rows="4" 
                            placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                        >
                            {{ old('descripcion', $categoriaHemogramaCompleto->descripcion) }}
                        </x-form.textarea-input>
                   
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    {{-- Botón Cancelar Estilizado --}}
                    <a href="{{ route('categoria_hemograma_completo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar cambios
                    </a>
                    
                    {{-- Botón Guardar con Icono --}}
                    <x-ui.button size="sm" type="submit" form="form-categoria-hemograma">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Categoría
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection