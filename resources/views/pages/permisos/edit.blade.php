@extends('layouts.app')

@section('title', 'Actualizar Llave de Acceso')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Header con Identidad Técnica --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-14 w-14 rounded-3xl bg-zinc-900 flex items-center justify-center text-zinc-400 shadow-xl shadow-zinc-200 dark:shadow-none border border-zinc-800">
            <i class="fa-solid fa-key-skeleton text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Modificar Permiso</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Editando clave: <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $permiso->nombre }}</span>
            </p>
        </div>
    </div>

    <form id="form-permisos" action="{{ route('permisos.update', $permiso) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card title="Configuración de la Llave" desc="Asegúrate de que la clave editada coincida con las directivas @can o Middleware en tu código." class="shadow-theme-md">
            
            <div class="space-y-6">
                {{-- Clave del Permiso --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Identificador (Slug)')" required />
                    <div class="relative mt-1 group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: ventas.editar"
                            class="lowercase w-full font-mono text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500/20"
                            :value="old('nombre', $permiso->nombre)" 
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-code text-xs"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                
                {{-- Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción Funcional')" />
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="Describe qué acceso otorga esta llave"
                            class="w-full"
                            :value="old('descripcion', $permiso->descripcion)" 
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                {{-- Advertencia de Impacto --}}
                <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 flex items-start gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0.5"></i>
                    <p class="text-[11px] text-red-700 dark:text-red-400 leading-relaxed font-medium">
                        <span class="font-bold uppercase tracking-tighter">Atención:</span> Alterar el identificador del permiso puede inhabilitar funciones en vivo si el código fuente del servidor no se actualiza simultáneamente.
                    </p>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('permisos.index') }}"
                        class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-permisos" class="shadow-lg shadow-indigo-500/20">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection