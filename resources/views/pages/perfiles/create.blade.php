@extends('layouts.app')

@section('title', 'Crear Perfil')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Perfil de Sistema</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define los roles y descripciones para la gestión de accesos.</p>
    </div>

    <form id="form-perfiles" action="{{ route('perfiles.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Datos del Perfil" desc="Información básica para identificar el nuevo rol." class="shadow-theme-md">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre del Perfil')" required/>
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: administrador, capturista"
                            :value="old('nombre')"
                            class="lowercase w-full pl-4"
                            :messages="$errors->get('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-1 text-xs text-gray-400 italic">El nombre se guardará automáticamente en minúsculas.</p>
                </div>

                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción Corta')" />
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="Define el propósito de este perfil"
                            :value="old('descripcion')"
                            class="w-full pl-4"
                            :messages="$errors->get('descripcion')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('perfiles.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-200">
                        <i class="fa-solid fa-arrow-left-long mr-2"></i> Cancelar y volver
                    </a>
                    
                    <div class="flex gap-3">
                        <x-form.button-primary 
                            type="submit"
                            form="form-perfiles"
                            class="shadow-indigo-200 dark:shadow-none"
                        >
                            <i class="fa-solid fa-plus-circle mr-2"></i> Crear Perfil
                        </x-form.button-primary>
                    </div>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection