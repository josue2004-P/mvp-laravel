@extends('layouts.app')

@section('title', 'Crear Permiso')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Nuevo Permiso</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define una nueva clave de acceso para los módulos del sistema.</p>
    </div>

    <form id="form-permisos" action="{{ route('permisos.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Datos del Permiso" desc="El nombre del permiso se utiliza para las validaciones de seguridad en el código." class="shadow-theme-md">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-form.input-label for="nombre" :value="__('Clave del Permiso (Nombre)')" required/>
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: reportes.ver, usuarios.editar"
                            :value="old('nombre')"
                            class="lowercase w-full"
                            :messages="$errors->get('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-1 text-[11px] text-gray-400 italic">Se recomienda usar minúsculas y puntos para separar módulos (ej. modulo.accion).</p>
                </div>

                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción del Permiso')" />
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="Permite visualizar los reportes mensuales"
                            :value="old('descripcion')"
                            class="w-full"
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
                        <i class="fa-solid fa-arrow-left-long mr-2"></i> Regresar al listado
                    </a>
                    
                    <div class="flex gap-3">
                        <x-form.button-primary 
                            type="submit"
                            form="form-permisos"
                            class="shadow-sm"
                        >
                            <i class="fa-solid fa-plus-circle mr-2"></i> Crear Permiso
                        </x-form.button-primary>
                    </div>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection