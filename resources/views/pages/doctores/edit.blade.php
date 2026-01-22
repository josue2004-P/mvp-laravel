@extends('layouts.app')

@section('title', 'Editar Doctor')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Perfil Profesional</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Actualizando datos del: <span class="font-semibold text-indigo-600">Dr. {{ $doctor->nombre }} {{ $doctor->apellido_paterno }}</span>
            </p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $doctor->is_activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            <span class="w-2 h-2 mr-2 rounded-full {{ $doctor->is_activo ? 'bg-green-500' : 'bg-red-500' }}"></span>
            {{ $doctor->is_activo ? 'Activo' : 'Inactivo' }}
        </span>
    </div>

    <form id="form-doctores" action="{{ route('doctores.update', $doctor->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-common.component-card title="Modificar Información" desc="Asegúrate de que la cédula y especialidad sean correctas." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Sección: Información Personal --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-user-md mr-2"></i>Datos del Especialista
                    </h3>
                </div>

                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre(s)')" required/>
                    <x-form.text-input type="text" name="nombre" :value="old('nombre', $doctor->nombre)" class="w-full mt-1" />    
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="apellido_paterno" :value="__('Apellido Paterno')" required/>
                        <x-form.text-input type="text" name="apellido_paterno" :value="old('apellido_paterno', $doctor->apellido_paterno)" class="w-full mt-1" />    
                    </div>
                    <div>
                        <x-form.input-label for="apellido_materno" :value="__('Apellido Materno')"/>
                        <x-form.text-input type="text" name="apellido_materno" :value="old('apellido_materno', $doctor->apellido_materno)" class="w-full mt-1" />    
                    </div>
                </div>

                <div>
                    <x-form.input-label for="email" :value="__('Correo Electrónico')"/>
                    <x-form.text-input type="email" name="email" :value="old('email', $doctor->email)" class="w-full mt-1 lowercase font-medium" />    
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="telefono" :value="__('Teléfono de Contacto')"/>
                    <x-form.text-input type="text" name="telefono" :value="old('telefono', $doctor->telefono)" class="w-full mt-1" />    
                </div>

                {{-- Sección: Profesional --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mt-4 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-id-card-clip mr-2"></i>Credenciales y Estado
                    </h3>
                </div>

                <div>
                    <x-form.input-label for="cedula_profesional" :value="__('Cédula Profesional')" required/>
                    <x-form.text-input type="text" name="cedula_profesional" :value="old('cedula_profesional', $doctor->cedula_profesional)" class="w-full mt-1 font-mono uppercase tracking-widest text-indigo-700 dark:text-indigo-300" />    
                    <x-form.input-error :messages="$errors->get('cedula_profesional')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="especialidad_id" :value="__('Especialidad')" required/>
                        <x-form.input-select name="especialidad_id" class="w-full mt-1 select2">
                            @foreach($especialidades as $especialidad)
                                <option value="{{ $especialidad->id }}" {{ old('especialidad_id', $doctor->especialidad_id) == $especialidad->id ? 'selected' : '' }}>
                                    {{ $especialidad->nombre }}
                                </option>
                            @endforeach
                        </x-form.input-select>
                    </div>
                    <div>
                        <x-form.input-label for="is_activo" :value="__('Estado Laboral')" />
                        <x-form.input-select name="is_activo" class="w-full mt-1">
                            <option value="1" {{ old('is_activo', $doctor->is_activo) == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_activo', $doctor->is_activo) == '0' ? 'selected' : '' }}>Inactivo</option>
                        </x-form.input-select>
                    </div>
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('doctores.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar Cambios
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-doctores">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Doctor
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection