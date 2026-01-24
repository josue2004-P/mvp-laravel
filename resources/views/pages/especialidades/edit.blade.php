@extends('layouts.app')

@section('title', 'Editar Especialidad')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado de Página --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Especialidad</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Actualiza la información de la especialidad: <strong>{{ $especialidad->nombre }}</strong></p>
    </div>

    <form id="form-especialidad" action="{{ route('especialidades.update', $especialidad->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-common.component-card title="Modificar Información" desc="Asegúrate de que los cambios sean correctos." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Especialidad')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            :value="old('nombre', $especialidad->nombre)"
                            class="w-full font-bold text-indigo-600 dark:text-indigo-400"
                            required
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción')" />
                    <div class="mt-1">
                        <x-form.textarea-input 
                            name="descripcion" 
                            id="descripcion" 
                            rows="4" 
                            placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                        >
                            {{ old('descripcion', $especialidad->descripcion) }}
                        </x-form.textarea-input>
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('especialidades.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar cambios
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-especialidad">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Especialidad
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection