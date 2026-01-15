@extends('layouts.app')

@section('title', 'Editar Tipo Metodo')

@section('content')

<x-common.component-card title="Editar Categoria Hemograma" desc="Edita la información principal del Categoria Hemograma." class="max-w-5xl">
    <form id="form-categoria-hemograma" action="{{ route('categoria_hemograma_completo.update', $categoriaHemogramaCompleto) }}" method="POST" class="space-y-5">
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
                :value="$categoriaHemogramaCompleto->nombre " 
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('categoria_hemograma_completo.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-categoria-hemograma">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </form>
</x-common.component-card>

@endsection
