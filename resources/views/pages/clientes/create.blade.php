@extends('layouts.app')

@section('title', 'Clientes Crear')

@section('content')

<x-common.component-card title="Formulario Clientes" desc="Completa la información para registrar un nuevo cliente." class="max-w-5xl">

    <form id="form-clientes" action="{{ route('clientes.store') }}" method="POST" class="grid grid-cols-2 gap-5">
    @csrf
        <!-- Elements -->
        <div>
            <x-form.input-label for="nombreCompleto" :value="__('Nombre Completo')" required/>
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre completo"
                :value="old('nombre')"
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="edad" :value="__('Edad')" required/>
            <x-form.text-input
                type="number"
                name="edad"
                placeholder="Escribe la edad"
                :value="old('edad')"
                :messages="$errors->get('edad')"
            />    
            <x-input-error :messages="$errors->get('edad')" class="mt-2" />
        </div>

        <!-- Elements -->

        <div>
            <x-form.input-label for="sexo" :value="__('Sexo')" required/>
            <x-form.input-select name="sexo" :messages="$errors->get('sexo')">
                <option value="">Selecciona una Opción</option>
                <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
            </x-form.input-select>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('clientes.index') }}"
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
