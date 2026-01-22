@extends('layouts.app')

@section('title', 'Crear Hemograma Completo')

@section('content')
<x-common.component-card title="Formulario Hemograma" desc="Completa la información para registrar un nuevo Hemograma." class="max-w-5xl">
    <form id="form-hemogramas" action="{{ route('hemograma_completo.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-1 gap-5">
    @csrf
        <!-- Elements -->
        <div>
            <x-form.input-label for="nombreCompleto" :value="__('Nombre Completo')" required/>
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Ej. Hemoglobina"
                :value="old('nombre')"
                :messages="$errors->get('nombre')"
            />    
            <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div>
            <x-form.input-label for="idCategoriaHemogramaCompleto" :value="__('Categoría')" required/>
            <x-form.input-select 
                id="idCategoriaHemogramaCompleto" 
                name="idCategoriaHemogramaCompleto"
                class="select2"
            >
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $c)
                    <option value="{{ $c->id }}" {{ old('idCategoriaHemogramaCompleto') == $c->id ? 'selected' : '' }}>
                        {{ $c->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
            <x-form.input-error :messages="$errors->get('idCategoriaHemogramaCompleto')" class="mt-2" />
        </div>

        <div>
            <x-form.input-label for="idUnidad" :value="__('Unidad')" required/>
            <x-form.input-select name="idUnidad" class="select2">
                <option value="">Selecciona una unidad</option>
                @foreach($unidades as $u)
                    <option value="{{ $u->id }}" {{ old('idUnidad') == $u->id ? 'selected' : '' }}>
                        {{ $u->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
            <x-form.input-error :messages="$errors->get('idUnidad')" class="mt-2" />
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="referencia" :value="__('Referencia')" />
            <x-form.text-input
                type="text"
                name="referencia"
                placeholder="Ej. 13.5 - 17.5 g/dL"
                :value="old('referencia')"
                :messages="$errors->get('referencia')"
            />    
            <x-form.input-error :messages="$errors->get('referencia')" class="mt-2" />
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('hemograma_completo.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-hemogramas">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>  
    </form>
</x-common.component-card>

@endsection