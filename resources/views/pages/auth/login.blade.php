@extends('layouts.fullscreen-layout')

@section('title','Login')
@section('titleCard','Iniciar Sesión')
@section('descripcionCard','Ingresa tu email y contraseña para iniciar sesión!')

@section('content')
    
<form  method="POST" action="{{ route('login') }}">
@csrf
    <div class="space-y-5">

        <!-- Usuario -->
        <div>
            <x-form.input-label for="usuario" required :value="__('Usuario')" />
            <x-form.text-input
                type="text"
                name="usuario"
                placeholder="Ingresa tu usuario"
                :value="old('usuario')"
                :messages="$errors->get('usuario')"
                required 
            autocomplete="current-password" 
            />
            <x-form.input-error :messages="$errors->get('usuario')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-form.input-label required for="password" :value="__('Password')" />
            <div x-data="{ showPassword: false }" class="relative">
                <x-form.text-input
                    name="password"
                    id="password"
                    placeholder="Ingresa tu contraseña"
                    :value="old('password')"
                    :messages="$errors->get('password')"
                    required 
                    show-password
                />
            </div>
            <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Checkbox -->
        <div class="flex items-center justify-between">
            <x-form.link href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </x-form.link>
        </div>

        <!-- Button -->
        <div class="pt-2">
            <x-ui.button 
                type="submit" 
                variant="primary" 
                size="lg" 
                full="true"
            >
                <x-slot:endIcon>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </x-slot:endIcon>
                
                Iniciar Sesión
            </x-ui.button>
        </div>
    </div>
</form>
 
@endsection
