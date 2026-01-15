@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')

<x-common.component-card title="Editar Perfil" desc="Edita la información principal del pefil." class="max-w-5xl">

    <form  id="form-perfiles" action="{{ route('perfiles.update', $perfil) }}" method="POST" class="max-w-7xl mx-auto">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <x-common.component-card title="Datos Generales" desc="" 
                class="max-w-5xl lg:col-span-2">
          
            <!-- Elements -->
                <div>
                    <x-form.input-label for="nombre" 
                        :value="__('Nombre:')" 
                        />
                    <x-form.text-input
                        type="text"
                        name="nombre"
                        placeholder="Escribe el nombre"
                        :value="$perfil->nombre " 
                        :messages="$errors->get('nombre')"
                    />    
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="descripcion" 
                        :value="__('Descripcion:')" 
                        />
                    <x-form.text-input
                        type="text"
                        name="descripcion"
                        placeholder="Escribe la descripcion"
                        :value="$perfil->descripcion " 
                        :messages="$errors->get('descripcion')"
                    />    
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <!-- Botones -->
                <x-slot:footer>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('perfiles.index') }}"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                        <x-ui.button size="sm" type="submit" form="form-perfiles">
                            Guardar
                        </x-ui.button>
                    </div>
                </x-slot:footer>
            </x-common.component-card>

            <x-common.component-card 
                title="Perfiles Asignados"
                desc="Selecciona los permisos y acciones disponibles para el perfil."
                class="max-w-5xl lg:col-span-2"
                >
                <div class="grid grid-cols-1 gap-4">
                    @foreach($permisos as $permiso)

                        @php
                            $pivot = $perfil->permisos
                                ->firstWhere('id', $permiso->id)
                                ?->pivot;
                        @endphp

                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] 
                                    text-gray-800 dark:text-white/90 px-4 py-4">

                            <!-- Permiso principal -->
                            <div class="flex items-start gap-4 mb-3">
                                <input
                                    type="checkbox"
                                    name="permisos[{{ $permiso->id }}][activo]"
                                    {{ $pivot ? 'checked' : '' }}
                                    class="mt-1 accent-blue-600"
                                >

                                <div>
                                    <p class="font-medium">{{ $permiso->nombre }}</p>
                                    <p class="text-sm opacity-80">{{ $permiso->descripcion }}</p>
                                </div>
                            </div>

                            <!-- Acciones CRUD -->
                            <div class="ml-8 grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">

                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        name="permisos[{{ $permiso->id }}][leer]"
                                        {{ $pivot?->leer ? 'checked' : '' }}
                                        class="accent-green-600"
                                    >
                                    Leer
                                </label>

                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        name="permisos[{{ $permiso->id }}][crear]"
                                        {{ $pivot?->crear ? 'checked' : '' }}
                                        class="accent-blue-600"
                                    >
                                    Crear
                                </label>

                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        name="permisos[{{ $permiso->id }}][actualizar]"
                                        {{ $pivot?->actualizar ? 'checked' : '' }}
                                        class="accent-yellow-600"
                                    >
                                    Editar
                                </label>

                                <label class="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        name="permisos[{{ $permiso->id }}][eliminar]"
                                        {{ $pivot?->eliminar ? 'checked' : '' }}
                                        class="accent-red-600"
                                    >
                                    Eliminar
                                </label>

                            </div>
                        </div>

                    @endforeach
                </div>
            </x-common.component-card>


        </div>

    </form>
</x-common.component-card>

@endsection
