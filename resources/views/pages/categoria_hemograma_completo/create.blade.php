@extends('layouts.app')

@section('title', 'Nueva Categoría de Hemograma')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Categoría de Análisis</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define una nueva categoría para la organización de parámetros de hemogramas.</p>
    </div>

    <form id="form-hemograma" action="{{ route('categoria_hemograma_completo.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Detalles de Categoría" desc="El nombre debe ser único para el catálogo." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Categoría')" required/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="nombre" placeholder="Ej. Serie Roja, Serie Blanca..." :value="old('nombre')" class="w-full" />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción o Notas')" />
                    <div class="mt-1">
                        <textarea name="descripcion" rows="4" 
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3"
                            placeholder="Describe qué parámetros incluye esta categoría..."
                        >{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('categoria_hemograma_completo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al listado
                    </a>
                    <x-ui.button size="sm" type="submit" form="form-hemograma">
                        <i class="fa-solid fa-plus mr-2"></i> Crear Categoría
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection