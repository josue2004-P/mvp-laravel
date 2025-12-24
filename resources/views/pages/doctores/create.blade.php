@extends('layouts.app')

@section('title', 'Crear Doctor')

@section('content')

<form id="form-doctores" action="{{ route('doctores.store') }}" method="POST" class="space-y-6">
@csrf
    <x-common.component-card title="Formulario Doctores" desc="Completa la información para registrar un nuevo Doctor." class="max-w-3xl">
        <!-- Elements -->
        <div>
            <x-form.input-label for="nombre" :value="__('Nombre:')" />
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre completo"
                :value="old('nombre')"
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('doctores.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-doctores">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-common.component-card>
</form>

@endsection
