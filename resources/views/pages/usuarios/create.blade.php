@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

<x-common.component-card title="Formulario Usuarios" desc="Completa la información para registrar un nuevo usuario." class="max-w-5xl">

    <form id="form-clientes" action="{{ route('usuarios.store') }}" method="POST" class="grid grid-cols-2 gap-5">
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
            <x-form.input-label for="email" :value="__('E-mail:')" required/>
            <x-form.text-input
                type="text"
                name="email"
                placeholder="Escribe el email"
                :value="old('email')"
                :messages="$errors->get('email')"
            />    
            <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="password" :value="__('Contraseña:')" required/>
            <x-form.text-input
                type="password"
                name="password"
                placeholder="Escribe el email"
                :value="old('password')"
                :messages="$errors->get('password')"
            />    
            <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="password_confirmation" :value="__('Confirmar Contraseña:')" required/>
            <x-form.text-input
                type="password"
                name="password_confirmation"
                placeholder="Repite la contraseña"
                :value="old('password_confirmation')"
                :messages="$errors->get('password_confirmation')"
            />    
            <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('usuarios.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-clientes">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>

    </form>

</x-common.component-card>
@endsection
