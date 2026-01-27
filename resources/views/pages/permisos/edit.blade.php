@extends('layouts.app')

@section('title', 'Actualizar Llave de Acceso')

@section('content')
<div class="max-w-2xl mx-auto transition-colors duration-300">
    {{-- Header con Identidad Técnica Emerald --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-14 w-14 rounded-3xl bg-slate-900 flex items-center justify-center text-emerald-500 shadow-xl shadow-slate-200 dark:shadow-none border border-slate-800">
            <i class="fa-solid fa-key text-lg"></i>

        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Modificar Permiso</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Editando clave: <span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $permiso->nombre }}</span>
            </p>
        </div>
    </div>

    <form id="form-permisos" action="{{ route('permisos.update', $permiso) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card title="Configuración de la Llave" desc="Asegúrate de que la clave editada coincida con las directivas @can o Middleware en tu código." class="shadow-xl border-slate-200 dark:border-slate-800">
            
            <div class="space-y-6 py-2">
                {{-- Clave del Permiso --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Identificador (Slug)')" required class="font-bold text-slate-700 dark:text-slate-300"/>
                    <div class="relative mt-1 group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: ventas.editar"
                            class="lowercase w-full font-mono text-emerald-600 dark:text-emerald-400 focus:ring-emerald-500/20"
                            :value="old('nombre', $permiso->nombre)" 
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <i class="fa-solid fa-code text-xs"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                
                {{-- Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción Funcional')" class="font-bold text-slate-700 dark:text-slate-300" />
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

                {{-- Advertencia de Impacto Rose Style --}}
                <div class="p-5 rounded-2xl bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/20 flex items-start gap-3 transition-all">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 mt-1"></i>
                    <p class="text-[11px] text-rose-700 dark:text-rose-400 leading-relaxed font-medium">
                        <span class="font-black uppercase tracking-widest text-rose-800 dark:text-rose-300">Atención:</span> Alterar el identificador del permiso puede inhabilitar funciones en vivo si el código fuente no se actualiza simultáneamente.
                    </p>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between py-2">
                    <a href="{{ route('permisos.index') }}"
                        class="text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors flex items-center group">
                        <i class="fa-solid fa-arrow-left-long mr-2 transition-transform group-hover:-translate-x-1"></i> Descartar
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-permisos" class="shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection