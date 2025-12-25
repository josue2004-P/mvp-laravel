@extends('layouts.app')

@section('title', 'Crear Tipo Metodo')

@section('content')
<x-common.component-card title="Formulario Tipo Metodo" desc="Completa la información para registrar un Tipo de Metodo." class="max-w-3xl">
    <form id="form-tipo-metodo" action="{{ route('tipo_metodo.store') }}" method="POST" class="space-y-6">
    @csrf
         <!-- Elements -->
        <div>
            <x-form.input-label for="nombre" 
                :value="__('Nombre:')" />
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre"
                :value="old('nombre')"
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>


                <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('tipo_metodo.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-tipo-metodo">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </form>
</x-common.component-card>
@endsection

