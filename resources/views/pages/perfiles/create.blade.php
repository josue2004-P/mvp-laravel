@extends('layouts.app')

@section('title', 'Nuevo Perfil de Sistema')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado con Icono Temático --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/10 shadow-sm">
            <i class="fa-solid fa-shield-halved text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Nuevo Perfil de Acceso</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Establece las bases para la jerarquía de permisos del laboratorio.</p>
        </div>
    </div>

    <form id="form-perfiles" action="{{ route('perfiles.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Arquitectura del Rol" desc="El nombre debe ser único y descriptivo para facilitar la administración." class="shadow-theme-md">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Nombre del Perfil --}}
                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Nombre Clave')" required/>
                    <div class="mt-1 relative group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: administrador, tecnico_lab"
                            :value="old('nombre')"
                            class="lowercase w-full font-mono text-indigo-600 dark:text-indigo-400"
                            :messages="$errors->get('nombre')"
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-focus-within:opacity-100 transition-opacity">
                            <i class="fa-solid fa-fingerprint text-xs text-indigo-500"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-2 text-[10px] text-gray-400 uppercase font-bold tracking-widest">
                        <i class="fa-solid fa-circle-info mr-1"></i> Se normalizará a minúsculas
                    </p>
                </div>

                {{-- Descripción --}}
                <div class="col-span-1">
                    <x-form.input-label for="descripcion" :value="__('Descripción Funcional')" />
                    <div class="mt-1">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="Ej. Acceso total a reportes"
                            :value="old('descripcion')"
                            class="w-full"
                            :messages="$errors->get('descripcion')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                {{-- Banner Informativo de Seguridad --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-dashed border-slate-200 dark:border-slate-800 flex items-start gap-4">
                        <div class="mt-1 text-slate-400">
                            <i class="fa-solid fa-lock-open text-sm"></i>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Al crear un nuevo perfil, este no tendrá permisos asignados por defecto. Deberás dirigirte a la sección de <span class="font-bold text-slate-700 dark:text-slate-200">Matriz de Permisos</span> para configurar qué módulos podrá ver o editar.
                        </p>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('perfiles.index') }}"
                        class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Cancelar Operación
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-perfiles">
                        <i class="fa-solid fa-shield-check mr-2"></i> Registrar Perfil
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection