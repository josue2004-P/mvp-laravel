@extends('layouts.app')

@section('title', 'Crear Estatus Analisis')

@section('content')
<form id="form-estatus-analisis" action="{{ route('estatus-analisis.store') }}" method="POST" class="">
@csrf

    <x-common.component-card title="Formulario Estatus Analisis" desc="Completa la información para registrar un nuevo Estatus Analisis." class="max-w-3xl">

        <!-- Elements -->
        <div>
            <x-form.input-label for="nombreCorto" :value="__('Nombre Corto:')" required/>
            <x-form.text-input
                type="text"
                name="nombreCorto"
                placeholder="Escribe el nombre del estatus"
                :value="old('nombreCorto')"
                :messages="$errors->get('nombreCorto')"
            />    
            <x-input-error :messages="$errors->get('nombreCorto')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="descripcion" :value="__('Descripcion:')" />
            <x-form.text-input
                type="text"
                name="descripcion"
                placeholder="Escribe la descripcion del estatus"
                :value="old('descripcion')"
                :messages="$errors->get('descripcion')"
            />    
            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3">
            <div>
                <x-form.input-label for="colorTexto" :value="__('Color Texto (Hex):')" />
                <x-form.color-input
                    name="colorTexto" {{-- Coincide con MySQL --}}
                    :color="old('colorTexto', '#000000')"
                />    
            </div>

            <div>
                <x-form.input-label for="colorFondo" :value="__('Color Fondo (Hex):')" />
                <x-form.color-input
                    name="colorFondo" {{-- Coincide con MySQL --}}
                    :color="old('colorFondo', '#FFFFFF')"
                />    
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3">
             <div class="col-span-2">
                <x-form.input-label :value="__('Estado del Análisis:')" />
            </div>
            <div class="col-span-1">
                <x-form.checkbox-input 
                    label="Abierto" 
                    name="analsisAbierto" 
                    value="1" 
                    :checked="old('analsisAbierto') == '1'"
                />
            </div>
            <div class="col-span-1">
                <x-form.checkbox-input 
                    label="Cerrado" 
                    name="analisisCerrado" 
                    value="1" 
                    :checked="old('analisisCerrado') == '1'"
                />
            </div>
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('estatus-analisis.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-estatus-analisis">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-common.component-card>
</form>
@endsection

