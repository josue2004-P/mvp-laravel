@extends('layouts.app')

@section('title', 'Configurar Perfil de Seguridad')

@section('content')
<div class="max-w-7xl mx-auto transition-colors duration-300">
    {{-- Header Emerald Style --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-3xl bg-slate-900 flex items-center justify-center text-emerald-500 shadow-xl shadow-slate-200 dark:shadow-none border border-slate-800">
                <i class="fa-solid fa-shield-halved text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Arquitectura de Accesos</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Definiendo capacidades para el perfil: <span class="font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">{{ $perfil->nombre }}</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <a href="{{ route('perfiles.index') }}" class="group inline-flex items-center px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i> 
                Volver al listado
            </a>
        </div>
    </div>

    <form id="form-perfiles" action="{{ route('perfiles.update', $perfil) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Columna Izquierda: Identificación --}}
            <div class="lg:col-span-4 space-y-6">
                <x-common.component-card title="Identidad del Rol" desc="Información administrativa del perfil.">
                    <div class="space-y-5 py-2">
                        <div>
                            <x-form.input-label for="nombre" :value="__('Nombre Clave')" required class="font-bold text-slate-700 dark:text-slate-300" />
                            <div class="mt-1 relative group">
                                <x-form.text-input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    class="w-full font-mono font-bold text-emerald-600 dark:text-emerald-400"
                                    :value="old('nombre', $perfil->nombre)"
                                />    
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-600">
                                    <i class="fa-solid fa-fingerprint text-xs"></i>
                                </div>
                            </div>
                            <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="descripcion" :value="__('Descripción Funcional')" class="font-bold text-slate-700 dark:text-slate-300" />
                            <x-form.text-input
                                type="text"
                                name="descripcion"
                                id="descripcion"
                                placeholder="Describre el propósito..."
                                class="w-full mt-1"
                                :value="old('descripcion', $perfil->descripcion)"
                            />    
                            <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>
                    </div>

                    <x-slot:footer>
                        <x-ui.button size="md" type="submit" form="form-perfiles" class="w-full shadow-lg shadow-emerald-500/20">
                            <i class="fa-solid fa-shield-check mr-2"></i> Guardar Configuración
                        </x-ui.button>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            {{-- Columna Derecha: Matriz de Permisos --}}
            <div class="lg:col-span-8">
                <x-common.component-card title="Matriz de Permisos" desc="Concede acciones específicas para cada módulo del sistema.">
                    <div class="space-y-3">
                        @foreach($permisos as $permiso)
                            @php $pivot = $perfil->permisos->firstWhere('id', $permiso->id)?->pivot; @endphp

                            <div class="rounded-3xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-white/[0.01] hover:border-emerald-500/30 transition-all duration-300 group">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 p-5">
                                    
                                    {{-- Información del Módulo --}}
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center text-emerald-500 shadow-sm border border-slate-100 dark:border-slate-800 group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-cube text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-sm text-slate-800 dark:text-slate-200 uppercase tracking-tight">{{ $permiso->nombre }}</p>
                                            <p class="text-[11px] text-slate-400 font-medium italic">{{ $permiso->descripcion }}</p>
                                        </div>
                                    </div>

                                    {{-- Acciones Disponibles con Colores Temáticos Refinados --}}
                                    <div class="flex flex-wrap items-center gap-2">
                                        {{-- Leer --}}
                                        <label class="flex items-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-emerald-500/50 transition-all group/opt">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_read]" {{ $pivot?->is_read ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/20 dark:bg-slate-800 dark:border-slate-600">
                                            <span class="ml-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover/opt:text-emerald-600 transition-colors">Leer</span>
                                        </label>

                                        {{-- Crear --}}
                                        <label class="flex items-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-cyan-500/50 transition-all group/opt">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_create]" {{ $pivot?->is_create ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500/20 dark:bg-slate-800 dark:border-slate-600">
                                            <span class="ml-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover/opt:text-cyan-600 transition-colors">Crear</span>
                                        </label>

                                        {{-- Editar --}}
                                        <label class="flex items-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-amber-500/50 transition-all group/opt">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_update]" {{ $pivot?->is_update ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500/20 dark:bg-slate-800 dark:border-slate-600">
                                            <span class="ml-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover/opt:text-amber-600 transition-colors">Editar</span>
                                        </label>

                                        {{-- Eliminar --}}
                                        <label class="flex items-center px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 cursor-pointer hover:border-rose-500/50 transition-all group/opt">
                                            <input type="checkbox" name="permisos[{{ $permiso->id }}][is_delete]" {{ $pivot?->is_delete ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500/20 dark:bg-slate-800 dark:border-slate-600">
                                            <span class="ml-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover/opt:text-rose-600 transition-colors">Eliminar</span>
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