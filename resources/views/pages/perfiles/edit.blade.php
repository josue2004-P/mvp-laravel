@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Configuración de Perfil</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Define las capacidades y accesos para el rol de sistema.</p>
        </div>
        <div class="flex items-center gap-2">
             <x-form.button-primary tag="a" href="{{ route('perfiles.index') }}" class="bg-gray-500 hover:bg-gray-600 !py-2">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver
            </x-form.button-primary>
        </div>
    </div>

    <form id="form-perfiles" action="{{ route('perfiles.update', $perfil) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-4 space-y-6">
                <x-common.component-card title="Datos Generales" desc="Identificación del perfil.">
                    <div class="space-y-4">
                        <div>
                            <x-form.input-label for="nombre" :value="__('Nombre del Perfil')" required />
                            <x-form.text-input
                                type="text"
                                name="nombre"
                                id="nombre"
                                placeholder="ejemplo: administrador"
                                class="w-full mt-1 lowercase"
                                :value="$perfil->nombre"
                                :messages="$errors->get('nombre')"
                            />    
                            <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="descripcion" :value="__('Descripción')" />
                            <x-form.text-input
                                type="text"
                                name="descripcion"
                                id="descripcion"
                                placeholder="Describe el uso de este perfil"
                                class="w-full mt-1"
                                :value="$perfil->descripcion"
                                :messages="$errors->get('descripcion')"
                            />    
                            <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>
                    </div>

                    <x-slot:footer>
                        <div class="flex justify-end gap-3">
                            <x-ui.button size="md" type="submit" form="form-perfiles" class="w-full">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                            </x-ui.button>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            <div class="lg:col-span-8">
                <x-common.component-card title="Matriz de Permisos" desc="Activa el módulo y selecciona las acciones permitidas.">
                    <div class="space-y-4">
                        @foreach($permisos as $permiso)
                            @php
                                $pivot = $perfil->permisos->firstWhere('id', $permiso->id)?->pivot;
                            @endphp

                            <div x-data="{ active: {{ $pivot ? 'true' : 'false' }} }" 
                                class="rounded-2xl border transition-all duration-200 p-5 bg-white dark:bg-white/[0.02]"
                                :class="active ? 'border-indigo-500 shadow-sm ring-1 ring-indigo-500/10' : 'border-gray-200 dark:border-gray-800'">

                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1">
                                            <input type="checkbox" 
                                                x-model="active"
                                                name="permisos[{{ $permiso->id }}][activo]" 
                                                class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white capitalize">{{ $permiso->nombre }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 italic">{{ $permiso->descripcion }}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-4 sm:gap-6" x-show="active" x-transition>
                                        <label class="inline-flex items-center group cursor-pointer">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_read]" {{ $pivot?->is_read ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-green-600 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900">
                                            <span class="ml-2 text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-green-600">Leer</span>
                                        </label>

                                        <label class="inline-flex items-center group cursor-pointer">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_create]" {{ $pivot?->is_create ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900">
                                            <span class="ml-2 text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-blue-600">Crear</span>
                                        </label>

                                        <label class="inline-flex items-center group cursor-pointer">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_update]" {{ $pivot?->is_update ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500 dark:border-gray-700 dark:bg-gray-900">
                                            <span class="ml-2 text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-yellow-600">Editar</span>
                                        </label>

                                        <label class="inline-flex items-center group cursor-pointer">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_delete]" {{ $pivot?->is_delete ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-red-600 focus:ring-red-500 dark:border-gray-700 dark:bg-gray-900">
                                            <span class="ml-2 text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-red-600">Eliminar</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-common.component-card>
            </div>

        </div>
    </form>
</div>
@endsection