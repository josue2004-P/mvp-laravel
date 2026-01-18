@extends('layouts.fullscreen-layout')

@section('title','Login')
@section('titleCard','Restablece Contraseña')
@section('descripcionCard','Ingresa tu email para restablecer la contraseña!')

@section('content')
<div class="mb-4 text-sm text-gray-600">
    {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente indícanos tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña y podrás elegir una nueva.') }}
</div>
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div>
        <x-form.input-label for="email" :value="__('Email:')" />
        <x-form.text-input type="text" name="email" placeholder="Escribe el email" :value="old('email')" :messages="$errors->get('email')"/>    
        <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-form.button-primary>
            {{ __('Email Password Reset Link') }}
        </x-form.button-primary>
    </div>
</form>
@endsection
