@extends('layouts.fullscreen-layout')

@section('title','Login')
@section('titleCard','Ingresa la nueva contraseña')
@section('descripcionCard','Ingresa tu nueva contraseña para restablecer!')

@section('content')
<form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div>
        <x-form.input-label for="email" required :value="__('Email')" />
        <x-form.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
        <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div x-data="{ showPassword: false }" class="relative mt-4">
        <x-form.input-label for="password_confirmation" required :value="__('Password')" />
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

    <div x-data="{ showPassword: false }" class="relative mt-4">
        <x-form.input-label for="password_confirmation" required :value="__('Confirm Password')" />
        <x-form.text-input
            name="password_confirmation"
            id="password_confirmation"
            placeholder="Confirma tu contraseña"
            :value="old('password_confirmation')"
            :messages="$errors->get('password_confirmation')"
            required 
            show-password
        />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-form.button-primary>
            {{ __('Reset Password') }}
        </x-form.button-primary>
    </div>  
</form>
@endsection

