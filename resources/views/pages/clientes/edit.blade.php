@extends('layouts.app')

@section('title', 'Clientes Crear')

@section('content')

<x-common.component-card title="Formulario Clientes" desc="Completa la información para editar un nuevo cliente." class="max-w-5xl">

    <form id="form-clientes" action="{{ route('clientes.update', $cliente) }}" method="POST" class="grid grid-cols-2 gap-5">
    @csrf
    @method('PUT')

        <!-- Elements -->
        <div>
            <x-form.input-label for="nombreCompleto" :value="__('Nombre Completo')" />
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre completo"
                :value=" $cliente->nombre "
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="edad" :value="__('Edad')" />
            <x-form.text-input
                type="text"
                name="edad"
                placeholder="Escribe la edad"
                :value="$cliente->edad"
                :messages="$errors->get('edad')"
            />    
            <x-input-error :messages="$errors->get('edad')" class="mt-2" />
        </div>

        <!-- Elements -->

        <div>
            <x-form.input-label for="sexo" :value="__('Sexo')" />
            <x-form.input-select name="sexo" :messages="$errors->get('sexo')">
                <option value="">Selecciona una Opción</option>
                <option value="MASCULINO" {{$cliente->sexo == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                <option value="FEMENINO" {{ $cliente->sexo == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
            </x-form.input-select>
        </div>

        <div>
            <x-form.input-label for="activo" :value="__('Activo')" />
            <x-form.input-select name="activo" :messages="$errors->get('activo')">
                <option value="">Selecciona una Opción</option>
                <option value="1" {{ $cliente->activo ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ !$cliente->activo ? 'selected' : '' }}>No</option>
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
