@extends('layouts.app')

@section('title', 'Nuevo Perfil de Sistema')

@section('content')
<div class="max-w-4xl mx-auto transition-colors duration-300">
    {{-- Encabezado con Icono Temático Emerald --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-12 w-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 shadow-sm">
            <i class="fa-solid fa-shield-halved text-xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Nuevo Perfil de Acceso</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Establece las bases para la jerarquía de permisos del sistema.</p>
        </div>
    </div>

    <form id="form-perfiles" action="{{ route('perfiles.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Arquitectura del Rol" desc="El nombre debe ser único y descriptivo para facilitar la administración." class="shadow-xl border-slate-200 dark:border-slate-800">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Nombre del Perfil --}}
                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Nombre Clave')" required class="font-bold text-slate-700 dark:text-slate-300"/>
                    <div class="mt-1 relative group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: administrador, tecnico_lab"
                            :value="old('nombre')"
                            class="lowercase w-full font-mono text-emerald-600 dark:text-emerald-400 focus:ring-emerald-500/20"
                            :messages="$errors->get('nombre')"
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-focus-within:opacity-100 transition-opacity">
                            <i class="fa-solid fa-fingerprint text-xs text-emerald-500"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-2 text-[10px] text-slate-400 uppercase font-bold tracking-widest">
                        <i class="fa-solid fa-circle-info mr-1 text-emerald-500"></i> Se normalizará a minúsculas
                    </p>
                </div>

                {{-- Descripción --}}
                <div class="col-span-1">
                    <x-form.input-label for="descripcion" :value="__('Descripción Funcional')" class="font-bold text-slate-700 dark:text-slate-300" />
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

                {{-- Banner Informativo de Seguridad Emerald Style --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-emerald-500/5 border border-dashed border-slate-200 dark:border-emerald-500/20 flex items-start gap-4 transition-all">
                        <div class="mt-1 text-emerald-500">
                            <i class="fa-solid fa-lock-open text-sm"></i>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Al crear un nuevo perfil, este no tendrá permisos asignados por defecto. Deberás dirigirte a la sección de <span class="font-bold text-emerald-600 dark:text-emerald-400">Matriz de Permisos</span> para configurar qué módulos podrá ver o editar.
                        </p>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between py-2">
                    <a href="{{ route('perfiles.index') }}"
                        class="text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors flex items-center group">
                        <i class="fa-solid fa-xmark mr-2 transition-transform group-hover:rotate-90"></i> Cancelar Operación
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-perfiles" class="shadow-emerald-900/20">
                        <i class="fa-solid fa-shield-check mr-2"></i> Registrar Perfil
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection