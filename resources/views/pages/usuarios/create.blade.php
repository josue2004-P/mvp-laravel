@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Nuevo Usuario</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Completa los datos para dar de alta un nuevo acceso al sistema.</p>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Información de Cuenta" desc="Define los datos personales y de acceso." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div class="col-span-1">
                    <x-form.input-label for="name" :value="__('Nombre Completo')" required/>
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="name"
                            type="text"
                            name="name"
                            placeholder="Ej. Pedro Picapiedra"
                            class="w-full pl-4"
                            :value="old('name')"
                            :messages="$errors->get('name')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="col-span-1">
                    <x-form.input-label for="email" :value="__('Correo Electrónico')" required />
                    <div class="relative mt-1">
                        <x-form.text-input
                            id="email"
                            type="email"
                            name="email"
                            class="lowercase w-full pl-4" 
                            placeholder="usuario@dominio.com"
                            :value="old('email')" 
                            :messages="$errors->get('email')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                    <p class="mt-1 text-[10px] text-gray-400 italic">El email se normalizará automáticamente a minúsculas.</p>
                </div>

                <div class="col-span-1 md:col-span-2 border-t border-gray-100 dark:border-gray-800 my-2 pt-4">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Seguridad</h3>
                </div>

                <div class="col-span-1">
                    <x-form.input-label for="password" :value="__('Contraseña')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Mínimo 8 caracteres"
                            class="w-full pl-4"
                            required 
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="col-span-1">
                    <x-form.input-label for="password_confirmation" :value="__('Confirmar Contraseña')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Repite la contraseña anterior"
                            class="w-full pl-4"
                            required 
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('usuarios.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                        <i class="fa-solid fa-arrow-left-long mr-2"></i> Cancelar y volver
                    </a>
                    
                    <div class="flex gap-2">
                        <x-form.button-primary 
                            type="submit"
                            form="form-usuarios"
                            class="shadow-sm"
                        >
                            <i class="fa-solid fa-user-plus mr-2"></i> Crear Usuario
                        </x-form.button-primary>
                    </div>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection