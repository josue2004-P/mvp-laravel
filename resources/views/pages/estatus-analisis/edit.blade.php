@extends('layouts.app')

@section('title', 'Editar Estatus Analisis')

@section('content')
<form id="form-estatus-analisis" action="{{ route('estatus-analisis.update', ['estatus' => $estatus->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <x-common.component-card title="Editar Estatus Analisis" desc="Modifica la información del estatus." class="max-w-3xl">

        <div class="space-y-4">
            <div>
                <x-form.input-label for="nombreCorto" :value="__('Nombre Corto:')" required/>
                <x-form.text-input
                    name="nombreCorto"
                    :value="old('nombreCorto', $estatus->nombreCorto)"
                    :messages="$errors->get('nombreCorto')"
                />
            </div>

            <div>
                <x-form.input-label for="descripcion" :value="__('Descripcion:')" />
                <x-form.text-input
                    name="descripcion"
                    :value="old('descripcion', $estatus->descripcion)"
                    :messages="$errors->get('descripcion')"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3">
                <div>
                    <x-form.input-label for="colorTexto" :value="__('Color Texto (Hex):')" />
                    <x-form.color-input
                        name="colorTexto"
                        :value="old('colorTexto', $estatus->colorTexto)"
                        :color="old('colorTexto', $estatus->colorTexto ?? '#000000')"
                    />
                </div>
                <div>
                    <x-form.input-label for="colorFondo" :value="__('Color Fondo (Hex):')" />
                    <x-form.color-input
                        name="colorFondo"
                        :value="old('colorFondo', $estatus->colorFondo)"
                        :color="old('colorFondo', $estatus->colorFondo ?? '#FFFFFF')"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-3 mt-4">
                <div class="col-span-2">
                    <x-form.input-label :value="__('Estado del Análisis:')" />
                </div>
                <div class="col-span-1">
                    <x-form.checkbox-input 
                        label="Abierto" 
                        name="analsisAbierto" 
                        value="1" 
                        :checked="old('analsisAbierto', $estatus->analsisAbierto) == 1"
                    />
                </div>
                <div class="col-span-1">
                    <x-form.checkbox-input 
                        label="Cerrado" 
                        name="analisisCerrado" 
                        value="1" 
                        :checked="old('analisisCerrado', $estatus->analisisCerrado) == 1"
                    />
                </div>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('estatus-analisis.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">Cancelar</a>
                <x-ui.button type="submit">Guardar Cambios</x-ui.button>
            </div>
        </x-slot:footer>
    </x-common.component-card>
</form>
@endsection