@extends('layouts.app')

@section('title', 'Crear Especialidad')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado de Página --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nueva Especialidad Médica</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define las categorías médicas para asignar a los doctores.</p>
    </div>

    <form id="form-especialidad" action="{{ route('especialidades.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Detalles de la Especialidad" desc="Información general de la rama médica." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Nombre --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Especialidad')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Cardiología, Pediatría, etc."
                            class="w-full"
                            :value="old('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción (Opcional)')" />
                    <div class="mt-1">
                        <textarea 
                            name="descripcion" 
                            id="descripcion"
                            rows="4"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3"
                            placeholder="Escribe una breve descripción sobre el alcance de esta especialidad..."
                        >{{ old('descripcion') }}</textarea>
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('especialidades.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Cancelar
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-especialidad">
                        <i class="fa-solid fa-save mr-2"></i> Guardar Especialidad
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection