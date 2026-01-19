@extends('layouts.app')

@section('title', 'Editar Tipo Metodo')

@section('content')

<x-common.component-card title="Editar Tipo de Metodo" desc="Edita la información principal del Tipo de Metodo." class="max-w-5xl">
    <form id="form-tipo-muestra" action="{{ route('tipo_metodo.update', $tipoMetodo) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

         <!-- Elements -->
        <div>
            <x-form.input-label for="nombre" 
                :value="__('Nombre:')" />
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre"
                :value="$tipoMetodo->nombre " 
                :messages="$errors->get('nombre')"
            />    
            <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('tipo_metodo.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-tipo-muestra">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </form>
</x-common.component-card>

@endsection
