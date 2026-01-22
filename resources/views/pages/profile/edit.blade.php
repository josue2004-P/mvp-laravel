@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Información del Perfil --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-transparent dark:border-gray-700">
                <div class="max-w-xl">
                    @include('pages.profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Actualizar Contraseña --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-transparent dark:border-gray-700">
                <div class="max-w-xl">
                    @include('pages.profile.partials.update-password-form')
                </div>
            </div>

            {{-- Eliminar Usuario --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-transparent dark:border-gray-700">
                <div class="max-w-xl">
                    @include('pages.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection

