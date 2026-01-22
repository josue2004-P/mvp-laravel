@extends('layouts.app')

@section('title', 'Configurar Cuenta de Usuario')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Encabezado con Identidad --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-5">
            <div class="h-16 w-16 rounded-3xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-500/20">
                <span class="text-2xl font-black">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Configurar Cuenta</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Editando a: <span class="font-bold text-indigo-600">{{ $usuario->email }}</span>
                </p>
            </div>
        </div>
        
        {{-- Badge de Estatus Rápido --}}
        <div class="hidden md:block">
            @if($usuario->is_activo)
                <span class="px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 text-xs font-bold uppercase tracking-widest">
                    <i class="fa-solid fa-circle-check mr-2"></i> Cuenta Activa
                </span>
            @else
                <span class="px-4 py-2 rounded-2xl bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 text-xs font-bold uppercase tracking-widest">
                    <i class="fa-solid fa-circle-xmark mr-2"></i> Acceso Restringido
                </span>
            @endif
        </div>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Columna Izquierda: Datos y Estado --}}
            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Credenciales Básicas" desc="Información esencial de contacto y acceso.">
                    <div class="space-y-6">
                        {{-- Nombre --}}
                        <div>
                            <x-form.input-label for="name" :value="__('Nombre Completo')" required />
                            <x-form.text-input
                                type="text"
                                name="name"
                                id="name"
                                :value="old('name', $usuario->name)"
                                class="w-full mt-1 font-bold"
                            />    
                            <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-form.input-label for="email" :value="__('Correo Electrónico')" required />
                            <x-form.text-input
                                type="email"
                                name="email"
                                id="email"
                                :value="old('email', $usuario->email)"
                                class="w-full mt-1 lowercase font-medium text-gray-600"
                            />    
                            <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <hr class="border-gray-100 dark:border-gray-800">

                        {{-- Toggle is_activo --}}
                        <div class="flex items-center justify-between p-4 rounded-2xl border border-indigo-50 bg-indigo-50/30 dark:border-indigo-500/10 dark:bg-indigo-500/5">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-white dark:bg-gray-900 flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100 dark:border-indigo-900/30">
                                    <i class="fa-solid fa-power-off"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-700 dark:text-white">Estado de Acceso</span>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_activo" value="1" class="sr-only peer" {{ old('is_activo', $usuario->is_activo) ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('usuarios.index') }}" class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark mr-1"></i> Cancelar
                            </a>
                            <x-ui.button size="sm" type="submit" form="form-usuarios">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Actualizar Cuenta
                            </x-ui.button>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            {{-- Columna Derecha: Roles y Permisos --}}
            <div class="lg:col-span-7">
                <x-common.component-card title="Perfiles de Seguridad" desc="Define los módulos y acciones permitidas para este usuario.">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($perfiles as $perfil)
                            <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border border-gray-100 bg-white hover:bg-indigo-50/50 dark:border-gray-800 dark:bg-white/[0.02] dark:hover:bg-indigo-500/5 transition-all group shadow-sm">
                                <div class="flex items-center h-5">
                                    <input 
                                        type="checkbox" 
                                        name="perfiles[]" 
                                        value="{{ $perfil->id }}" 
                                        {{ $usuario->perfiles->contains($perfil->id) ? 'checked' : '' }}
                                        class="h-6 w-6 rounded-lg border-gray-200 text-indigo-600 focus:ring-4 focus:ring-indigo-500/10 dark:border-gray-700 dark:bg-gray-900 transition-all"
                                    >
                                </div>
                                <div class="ml-4">
                                    <span class="block font-extrabold text-sm text-gray-800 dark:text-gray-200 group-hover:text-indigo-600 transition-colors">
                                        {{ $perfil->nombre }}
                                    </span>
                                    <span class="block text-[11px] text-gray-400 font-medium uppercase tracking-tighter mt-0.5">
                                        {{ $perfil->descripcion ?: 'Acceso estándar al módulo' }}
                                    </span>
                                </div>
                                {{-- Checkmark visual --}}
                                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-20 transition-opacity">
                                    <i class="fa-solid fa-shield-halved text-indigo-600"></i>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </x-common.component-card>
            </div>

        </div>
    </form>
</div>
@endsection