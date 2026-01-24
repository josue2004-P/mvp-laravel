@extends('layouts.app')

@section('title', 'Editar Tipo de Muestra')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Configuración de Muestra</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Modificando el registro: <span class="font-bold text-amber-600 dark:text-amber-400">{{ $tipoMuestra->nombre }}</span>
        </p>
    </div>

    <form id="form-tipo-muestra" action="{{ route('tipo_muestra.update', $tipoMuestra->id) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card title="Actualizar Información" desc="Asegúrate de que los cambios no afecten la interpretación de las órdenes actuales." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Campo Nombre --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Muestra')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            class="w-full font-bold text-amber-700 dark:text-amber-400 uppercase"
                            :value="old('nombre', $tipoMuestra->nombre)"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Campo Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción o Instrucciones')" />
                    <div class="mt-1">
                        <x-form.textarea-input 
                            name="descripcion" 
                            id="descripcion" 
                            rows="4" 
                            placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                        >
                            {{ old('descripcion', $tipoMuestra->descripcion) }}
                        </x-form.textarea-input>
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('tipo_muestra.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar cambios
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-tipo-muestra">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Registro
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection