@extends('layouts.app')

@section('title', 'Editar Tipo de Método')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Método Analítico</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Actualizando: <span class="font-bold text-teal-600">{{ $tipoMetodo->nombre }}</span>
        </p>
    </div>

    <form id="form-tipo-metodo" action="{{ route('tipo_metodo.update', $tipoMetodo->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-common.component-card title="Modificar Información" desc="Asegúrate de que el nombre coincida con la terminología oficial del laboratorio." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre del Método')" required/>
                    <x-form.text-input
                        id="nombre"
                        type="text"
                        name="nombre"
                        class="w-full mt-1 font-bold text-teal-700 dark:text-teal-400"
                        :value="old('nombre', $tipoMetodo->nombre)"
                    />
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción')" />
                    <textarea 
                        name="descripcion" 
                        rows="4"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3"
                    >{{ old('descripcion', $tipoMetodo->descripcion) }}</textarea>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('tipo_metodo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-tipo-metodo">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Método
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection