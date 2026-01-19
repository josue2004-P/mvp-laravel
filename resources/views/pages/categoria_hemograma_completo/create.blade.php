@extends('layouts.app')

@section('title', 'Crear Categoria Hemograma')

@section('content')
<x-common.component-card title="Formulario Categoria Hemograma" desc="Completa la información para registrar una Categoria Hemograma." class="max-w-3xl">
    <form id="form-tipo-metodo" action="{{ route('categoria_hemograma_completo.store') }}" method="POST" class="space-y-6">
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
            <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>


                <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('categoria_hemograma_completo.index') }}"
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

