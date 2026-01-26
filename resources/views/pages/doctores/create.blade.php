@extends('layouts.app')

@section('title', 'Registrar Doctor')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Nuevo Especialista</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Completa el perfil profesional y personal del médico para integrarlo al sistema.</p>
    </div>

    <form id="form-doctores" action="{{ route('doctores.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Perfil del Doctor" desc="La información profesional será visible en el catálogo de especialistas." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Sección: Información Personal --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-user-md mr-2"></i>Información Personal
                    </h3>
                </div>

                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Nombre(s)')" required/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="nombre" placeholder="Nombre completo" :value="old('nombre')" class="w-full" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="apellido_paterno" :value="__('Apellido Paterno')" required/>
                        <x-form.text-input type="text" name="apellido_paterno" placeholder="Primer Apellido" :value="old('apellido_paterno')" class="w-full mt-1" />    
                        <x-form.input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                    </div>
                    <div>
                        <x-form.input-label for="apellido_materno" :value="__('Apellido Materno')"/>
                        <x-form.text-input type="text" name="apellido_materno" placeholder="Segundo Apellido" :value="old('apellido_materno')" class="w-full mt-1" />    
                    </div>
                </div>

                <div>
                    <x-form.input-label for="email" :value="__('Correo Electrónico Institucional')"/>
                    <div class="mt-1">
                        <x-form.text-input type="email" name="email" placeholder="doctor@clinica.com" :value="old('email')" class="w-full lowercase font-medium" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="telefono" :value="__('Teléfono de Contacto')"/>
                    <div class="mt-1">
                        <x-form.text-input type="number" name="telefono" placeholder="Ej. 123 456 7890" :value="old('telefono')" class="w-full" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                {{-- Sección: Información Profesional --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mt-4 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-id-card-clip mr-2"></i>Credenciales Profesionales
                    </h3>
                </div>

                <div>
                    <x-form.input-label for="cedula_profesional" :value="__('Cédula Profesional')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            type="text"
                            name="cedula_profesional"
                            placeholder="Número de Registro"
                            :value="old('cedula_profesional')"
                            class="w-full font-mono uppercase tracking-widest text-indigo-700 dark:text-indigo-300"
                        />    
                    </div>
                    <x-form.input-error :messages="$errors->get('cedula_profesional')" class="mt-2" />
                </div>
                <div>
                    <x-form.input-label for="especialidades" :value="__('Especialidades Médicas')" required/>
                    <div class="mt-1">
                        <x-form.input-tags 
                            name="especialidades" 
                            :options="$especialidades" 
                            :selected="old('especialidades', isset($doctor) ? $doctor->especialidades->pluck('id')->toArray() : [])"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('especialidades')" class="mt-2" />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('doctores.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Cancelar y volver
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-doctores">
                        <i class="fa-solid fa-user-plus mr-2"></i> Registrar Doctor
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection