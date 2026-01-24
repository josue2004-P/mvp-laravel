@extends('layouts.app')

@section('title', 'Editar Unidad')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Unidad</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Modificando la unidad: <span class="font-bold text-indigo-600">{{ $unidad->nombre }}</span>
        </p>
    </div>

    <form id="form-unidades" action="{{ route('unidades.update', $unidad->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-common.component-card title="Actualizar Información" desc="Cualquier cambio afectará la visualización en los reportes de resultados." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-form.input-label for="nombre" :value="__('Símbolo o Nombre de la Unidad')" required/>
                    <x-form.text-input
                        id="nombre"
                        type="text"
                        name="nombre"
                        class="w-full mt-1 font-bold text-indigo-600"
                        :value="old('nombre', $unidad->nombre)"
                    />
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción Técnica')" />
                    <x-form.textarea-input 
                        name="descripcion" 
                        id="descripcion" 
                        rows="4" 
                        placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                    >
                        {{ old('descripcion', $unidad->descripcion) }}
                    </x-form.textarea-input>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('unidades.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-unidades">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Unidad
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection