@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<x-common.component-card title="Editar Usuario" desc="Edita la información principal del usuario." class="max-w-5xl">

    <form id="form-usuarios" action="{{ route('usuarios.update', $usuario) }}" method="POST"  class="max-w-7xl mx-auto">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <x-common.component-card title="Datos Generales" desc="" 
                class="max-w-5xl lg:col-span-2">
          
            <!-- Elements -->
                <div>
                    <x-form.input-label for="name" 
                        :value="__('Nombre:')" 
                        />
                    <x-form.text-input
                        type="text"
                        name="name"
                        placeholder="Escribe el nombre"
                        :value="$usuario->name " 
                        :messages="$errors->get('name')"
                    />    
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="email" 
                        :value="__('Email:')" 
                        />
                    <x-form.text-input
                        type="text"
                        name="email"
                        placeholder="Escribe el email"
                        :value="$usuario->email " 
                        :messages="$errors->get('email')"
                    />    
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Botones -->
                <x-slot:footer>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('usuarios.index') }}"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                        <x-ui.button size="sm" type="submit" form="form-usuarios">
                            Guardar
                        </x-ui.button>
                    </div>
                </x-slot:footer>
            </x-common.component-card>

            <x-common.component-card title="Perfiles Asignados" desc="Selecciona los perfiles que deseas asignar al usuario." class="max-w-5xl lg:col-span-2">

                <div class="grid grid-cols-1 gap-4">
                    @foreach($perfiles as $perfil)

                        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] flex text-gray-800 dark:text-white/90 px-4 py-4 gap-4">
                            <input 
                                type="checkbox" 
                                name="perfiles[]" 
                                value="{{ $perfil->id }}" 
                                {{ $usuario->perfiles->contains($perfil->id) ? 'checked' : '' }}
                                class="mt-1  accent-blue-600"
                                >
                                <div>
                                    <p class="font-medium ">{{ $perfil->nombre }}</p>
                                    <p class="text-sm ">{{ $perfil->descripcion }}</p>
                                </div>
                    
                        </div>
                    @endforeach
                </div>
            </x-common.component-card>

        </div>
    </form>

</x-common.component-card>

@endsection
