@extends('layouts.app')

@section('title', 'Editar Permiso')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Actualizar Permiso</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Modifica la clave o descripción del permiso de acceso.</p>
    </div>

    <form id="form-permisos" action="{{ route('permisos.update', $permiso) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card title="Información del Permiso" desc="Asegúrate de que la clave coincida con la usada en el código del sistema." class="shadow-theme-md">
            
            <div class="space-y-5">
                <div>
                    <x-form.input-label for="nombre" :value="__('Clave del Permiso')" required />
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: ventas.editar"
                            {{-- Mantenemos lowercase para consistencia con el controlador --}}
                            class="lowercase w-full pl-4"
                            :value="$permiso->nombre" 
                            :messages="$errors->get('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-1 text-[11px] text-gray-400 italic">Este campo es sensible a cambios; úsalo con precaución.</p>
                </div>
                
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción')" />
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="Escribe una descripción clara"
                            class="w-full pl-4"
                            :value="$permiso->descripcion" 
                            :messages="$errors->get('descripcion')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('permisos.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                        <i class="fa-solid fa-arrow-left-long mr-2"></i> Cancelar
                    </a>
                    
                    <div class="flex gap-2">
                        <x-form.button-primary 
                            type="submit"
                            form="form-permisos"
                            class="shadow-sm"
                        >
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Actualizar Registro
                        </x-form.button-primary>
                    </div>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection