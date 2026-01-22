@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Nuevo Usuario</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Configura las credenciales y el estado de acceso para el nuevo miembro del equipo.</p>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Información de Cuenta" desc="Define los datos personales y el nivel de acceso inicial." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Nombre Completo --}}
                <div class="col-span-1">
                    <x-form.input-label for="name" :value="__('Nombre Completo')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="name"
                            type="text"
                            name="name"
                            placeholder="Ej. Pedro Picapiedra"
                            class="w-full font-semibold"
                            :value="old('name')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Correo Electrónico --}}
                <div class="col-span-1">
                    <x-form.input-label for="email" :value="__('Correo Electrónico')" required />
                    <div class="mt-1">
                        <x-form.text-input
                            id="email"
                            type="email"
                            name="email"
                            class="lowercase w-full" 
                            placeholder="usuario@dominio.com"
                            :value="old('email')" 
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Control de Estado (is_activo) --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center justify-between p-4 rounded-2xl border border-indigo-50 bg-indigo-50/30 dark:border-indigo-500/10 dark:bg-indigo-500/5">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl bg-white dark:bg-gray-900 shadow-sm flex items-center justify-center text-indigo-600 border border-indigo-100 dark:border-indigo-900/50">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Estado de la Cuenta</h4>
                                <p class="text-[11px] text-gray-500">¿Permitir el acceso inmediato al sistema tras el registro?</p>
                            </div>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_activo" value="1" class="sr-only peer" {{ old('is_activo', '1') == '1' ? 'checked' : '' }}>
                            <div class="w-12 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600 shadow-inner"></div>
                            <span class="ml-3 text-[10px] font-extrabold uppercase tracking-widest text-gray-400 peer-checked:text-indigo-600 transition-colors">
                                Habilitada
                            </span>
                        </label>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 border-t border-gray-100 dark:border-gray-800 my-2 pt-4">
                    <h3 class="text-xs font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-[0.2em]">Credenciales de Seguridad</h3>
                </div>

                {{-- Contraseña --}}
                <div class="col-span-1">
                    <x-form.input-label for="password" :value="__('Contraseña Temporal')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Mínimo 8 caracteres"
                            class="w-full"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirmación --}}
                <div class="col-span-1">
                    <x-form.input-label for="password_confirmation" :value="__('Confirmar Contraseña')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Repite la contraseña"
                            class="w-full"
                        />
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('usuarios.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Cancelar Registro
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-usuarios">
                        <i class="fa-solid fa-user-check mr-2"></i> Crear y Guardar
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection