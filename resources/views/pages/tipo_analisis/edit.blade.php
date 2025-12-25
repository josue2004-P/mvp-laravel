@extends('layouts.app')

@section('title', 'Editar Tipo Analisis')

@section('content')

<x-common.component-card title="Editar Tipo de Analisis" desc="Edita la información principal del Tipo de Analisis." class="max-w-5xl">
    <form id="form-tipo-analisis" action="{{ route('tipo_analisis.update', $tipoAnalisis) }}" method="POST" class="space-y-5">
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
                :value="$tipoAnalisis->nombre " 
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('tipo_analisis.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-tipo-analisis">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </form>
</x-common.component-card>

@endsection
