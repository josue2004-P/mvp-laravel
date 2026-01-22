@extends('layouts.app')

@section('title', 'Nueva Unidad de Medida')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Unidad de Medida</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Registra las unidades técnicas (ej. mg/dL, g/L) para los resultados de análisis.</p>
    </div>

    <form id="form-unidades" action="{{ route('unidades.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Configuración de Unidad" desc="Define el símbolo y la descripción técnica de la unidad." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="flex items-center gap-4 p-4 rounded-xl bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20">
                    <div class="h-12 w-12 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-ruler-combined text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-400 uppercase tracking-tight">Estándar de Medición</h4>
                        <p class="text-xs text-indigo-700 dark:text-indigo-500/80">Asegúrate de usar la nomenclatura correcta según el Sistema Internacional.</p>
                    </div>
                </div> --}}

                {{-- Nombre de la Unidad --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Símbolo o Nombre de la Unidad')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. mg/dL, cells/mm³, g/L"
                            class="w-full font-semibold"
                            :value="old('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción Técnica (Opcional)')" />
                    <div class="mt-1">
                        <textarea 
                            name="descripcion" 
                            id="descripcion"
                            rows="4"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3 transition"
                            placeholder="Escribe para qué tipo de estudios se utiliza esta unidad..."
                        >{{ old('descripcion') }}</textarea>
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('unidades.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al catálogo
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-unidades">
                        <i class="fa-solid fa-flask mr-2"></i> Guardar Unidad
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection