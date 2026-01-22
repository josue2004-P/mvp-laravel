@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Usuario</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Actualiza los privilegios y datos básicos de la cuenta.</p>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Datos Generales" desc="Información básica de acceso.">
                    <div class="space-y-4">
                        <div>
                            <x-form.input-label for="name" :value="__('Nombre Completo')" />
                            <x-form.text-input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Escribe el nombre"
                                :value="$usuario->name"
                                class="w-full mt-1"
                            />    
                            <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="email" :value="__('Correo Electrónico')" />
                            <x-form.text-input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="ejemplo@dominio.com"
                                :value="$usuario->email"
                                class="w-full mt-1"
                            />    
                            <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between gap-3">
                            <a href="{{ route('usuarios.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition">
                                <i class="fa-solid fa-arrow-left mr-1"></i> Volver a la lista
                            </a>
                            <div class="flex gap-2">
                                <x-form.button-primary 
                                    type="submit"
                                    form="form-usuarios"
                                    class="w-full lg:w-auto shadow-sm"
                                >
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                                </x-form.button-primary>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            <div class="lg:col-span-7">
                <x-common.component-card title="Perfiles y Permisos" desc="Define qué puede hacer este usuario en el sistema.">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($perfiles as $perfil)
                            <label class="relative flex items-start p-4 cursor-pointer rounded-xl border border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:hover:bg-white/[0.05] transition-all group">
                                <div class="flex items-center h-5">
                                    <input 
                                        type="checkbox" 
                                        name="perfiles[]" 
                                        value="{{ $perfil->id }}" 
                                        {{ $usuario->perfiles->contains($perfil->id) ? 'checked' : '' }}
                                        class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-700 dark:bg-gray-900"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="block font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                        {{ $perfil->nombre }}
                                    </span>
                                    <span class="block text-gray-500 dark:text-gray-400 italic text-xs mt-0.5">
                                        {{ $perfil->descripcion }}
                                    </span>
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