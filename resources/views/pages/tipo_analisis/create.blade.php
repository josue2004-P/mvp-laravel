@extends('layouts.app')

@section('title', 'Nuevo Tipo de Análisis')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Clasificación de Análisis</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define grupos principales para organizar los estudios (ej. Hematología, Bioquímica, Inmunología).</p>
    </div>

    <form id="form-tipo-analisis" action="{{ route('tipo_analisis.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Configuración de Clasificación" desc="Esta categoría agrupará diversos estudios en el catálogo médico." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="flex items-center gap-4 p-4 rounded-xl bg-purple-50 dark:bg-purple-900/10 border border-purple-100 dark:border-purple-900/20 mb-2">
                    <div class="h-12 w-12 rounded-lg bg-purple-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-layer-group text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-purple-900 dark:text-purple-400 uppercase tracking-tight">Jerarquía de Laboratorio</h4>
                        <p class="text-xs text-purple-700 dark:text-purple-500/80">Los tipos de análisis facilitan la organización de reportes y la facturación por departamentos.</p>
                    </div>
                </div> --}}

                {{-- Campo Nombre --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Clasificación')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Bioquímica Clínica, Serología, Parasitología"
                            class="w-full font-semibold"
                            :value="old('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Campo Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción o Notas del Área')" />
                    <div class="mt-1">
                        <x-form.textarea-input 
                            name="descripcion" 
                            id="descripcion" 
                            rows="4" 
                            placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                        >
                            {{ old('descripcion') }}
                        </x-form.textarea-input>
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('tipo_analisis.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al catálogo
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-tipo-analisis">
                        <i class="fa-solid fa-folder-plus mr-2"></i> Guardar Clasificación
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection