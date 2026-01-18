@extends('layouts.fullscreen-layout')

@section('title','Login')
@section('titleCard','Iniciar Sesión')
@section('descripcionCard','Ingresa tu email y contraseña para iniciar sesión!')

@section('content')
    
<form  method="POST" action="{{ route('login') }}">
@csrf
    <div class="space-y-5">

        <!-- Email -->
        <div>
            <x-form.input-label for="email" required :value="__('Email')" />
            <x-form.text-input
                type="email"
                name="email"
                placeholder="info@gmail.com"
                :value="old('email')"
                :messages="$errors->get('email')"
                required 
            autocomplete="current-password" 
            />
            <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
            
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
        <div>
            <x-form.button-primary>
                Iniciar Sesión
            </x-form.button-primary>
        </div>
    </div>
</form>
 
@endsection
