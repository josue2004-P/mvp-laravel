@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

<form id="form-permisos"  action="{{ route('permisos.update', $permiso) }}" method="POST" >

    <x-common.component-card title="Editar Permiso" desc="Edita la información principal del permiso." class="max-w-xl">

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
                :value="$permiso->nombre " 
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>
                
        <!-- Elements -->
        <div>
            <x-form.input-label for="descripcion" 
                :value="__('Descripción:')" />
            <x-form.text-input
                type="text"
                name="descripcion"
                placeholder="Escribe la descripcion"
                :value="$permiso->descripcion " 
                :messages="$errors->get('descripcion')"
            />    
            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
        </div>

    <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('permisos.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-permisos">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-common.component-card>
</form>

@endsection

