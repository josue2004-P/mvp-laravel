@extends('layouts.app')

@section('title', 'Editar Hemograma Completo')

@section('content')

<x-common.component-card title="Formulario Hemograma" desc="Completa la información para editar un nuevo Hemograma." class="max-w-5xl">

    <form id="form-hemogaramas" action="{{ route('hemograma_completo.update', $hemogramaCompleto) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

        <!-- Elements -->
        <div>
            <x-form.input-label for="nombreCompleto" :value="__('Nombre Completo')" required/>
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Ej. Hemoglobina"
                :value="$hemogramaCompleto->nombre"
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div>
            <x-form.input-label for="categoria" :value="__('Categoría')" required/>
            <x-form.input-select name="idCategoriaHemogramaCompleto"         class="select2-search" 
 :messages="$errors->get('idCategoriaHemogramaCompleto')">
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $c)
                    <option value="{{ $c->id }}" {{ $hemogramaCompleto->idCategoriaHemogramaCompleto == $c->id ? 'selected' : '' }}>
                        {{ $c->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
        </div>

        <div>
            <x-form.input-label for="categoria" :value="__('Unidad')" required/>
            <x-form.input-select name="idUnidad"         class="select2-search" 
 :messages="$errors->get('idUnidad')">
                <option value="">Selecciona una unidad</option>
                @foreach($unidades as $u)
                    <option value="{{ $u->id }}" {{ $hemogramaCompleto->idUnidad == $u->id ? 'selected' : '' }}>
                        {{ $u->nombre }}
                    </option>
                @endforeach
            </x-form.input-select>
        </div>

        <!-- Elements -->
        <div>
            <x-form.input-label for="referencia" :value="__('Referencia')" />
            <x-form.text-input
                type="text"
                name="referencia"
                placeholder="Ej. 13.5 - 17.5 g/dL"
                :value="$hemogramaCompleto->referencia "
                :messages="$errors->get('referencia')"
            />    
            <x-input-error :messages="$errors->get('referencia')" class="mt-2" />
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('hemograma_completo.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-hemogaramas">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </form>
</x-common.component-card>
@endsection