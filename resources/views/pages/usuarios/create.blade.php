@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<x-common.component-card title="Formulario Usuarios" desc="Completa la información para registrar un nuevo usuario." class="max-w-5xl">

    <form id="form-usuarios" action="{{ route('usuarios.store') }}" method="POST" class="grid grid-cols-2 gap-5">
    @csrf
        <!-- Elements -->
        <div>
            <x-form.input-label for="name" :value="__('Nombre Completo:')" required/>
            <x-form.text-input
                type="text"
                name="name"
                placeholder="Escribe el nombre completo"
                :value="old('name')"
                :messages="$errors->get('name')"
            />    
            <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            {{-- Label con asterisco de requerido --}}
            <x-form.input-label for="email" :value="__('Correo Electrónico')" required />
            
            <div class="relative mt-1">
                <x-form.text-input
                    id="email"
                    type="email"
                    name="email"
                    class="lowercase w-full" 
                    placeholder="admin@dominio.com"
                    :value="old('email', $usuario->email ?? '')" 
                    :messages="$errors->get('email')"
                />
            </div>
            
            <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="password" :value="__('Contraseña:')" required/>
            <div x-data="{ showPassword: false }" class="relative">
                <x-form.text-input
                    name="password"
                    id="password"
                    placeholder="Escribe la contraseña"
                    :value="old('password')"
                    :messages="$errors->get('password')"
                    required 
                    show-password
                />
            </div>
            <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="password_confirmation" :value="__('Confirmar Contraseña:')" required/>
            <div x-data="{ showPassword: false }" class="relative">
                <x-form.text-input
                    type="password"
                    name="password_confirmation"
                    placeholder="Repite la contraseña"
                    :value="old('password_confirmation')"
                    :messages="$errors->get('password_confirmation')"
                    required 
                    show-password
                />
            </div>
            <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
    </form>

</x-common.component-card>
@endsection
