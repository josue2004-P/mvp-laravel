@extends('layouts.app')

@section('title', 'Crear Perfil')

@section('content')

<form id="form-perfiles" action="{{ route('perfiles.store') }}" method="POST" class="space-y-6">
@csrf
    <x-common.component-card title="Formulario Perfiles" desc="Completa la información para registrar un nuevo Perfil." class="max-w-3xl">

        <!-- Elements -->
        <div>
            <x-form.input-label for="nombre" :value="__('Nombre:')" required/>
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre del perfil"
                :value="old('nombre')"
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="descripcion" :value="__('Descripcion:')" />
            <x-form.text-input
                type="text"
                name="descripcion"
                placeholder="Escribe la descripcion del perfil"
                :value="old('descripcion')"
                :messages="$errors->get('descripcion')"
            />    
            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('perfiles.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-perfiles">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-common.component-card>
</form>

@endsection
