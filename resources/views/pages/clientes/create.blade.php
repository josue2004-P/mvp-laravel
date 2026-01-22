@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrar Nuevo Cliente</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Ingresa los datos personales y de ubicación para el expediente del cliente.</p>
    </div>

    <form id="form-clientes" action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Expediente de Cliente" desc="La información marcada con asterisco es obligatoria." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Sección: Información Personal --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-user-tag mr-2"></i>Información Personal
                    </h3>
                </div>

                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre(s)')" required/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="nombre" placeholder="Ej. Juan" :value="old('nombre')" class="w-full" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="apellido_paterno" :value="__('Apellido Paterno')" required/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="apellido_paterno" placeholder="Ej. Pérez" :value="old('apellido_paterno')" class="w-full" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="apellido_materno" :value="__('Apellido Materno')"/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="apellido_materno" placeholder="Ej. García" :value="old('apellido_materno')" class="w-full" />    
                    </div>
                </div>

                <div>
                    <x-form.input-label for="email" :value="__('Correo Electrónico')"/>
                    <div class="mt-1">
                        <x-form.text-input type="email" name="email" placeholder="correo@ejemplo.com" :value="old('email')" class="w-full lowercase" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="edad" :value="__('Edad')" required/>
                        <div class="mt-1">
                            <x-form.text-input type="number" name="edad" placeholder="00" :value="old('edad')" class="w-full" />    
                        </div>
                    </div>
                    <div>
                        <x-form.input-label for="sexo" :value="__('Sexo')" required/>
                        <div class="mt-1">
                            <x-form.input-select name="sexo" class="w-full">
                                <option value="">Seleccionar...</option>
                                <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                                <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                                <option value="OTRO" {{ old('sexo') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                            </x-form.input-select>
                        </div>
                    </div>
                </div>

                <div>
                    <x-form.input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')"/>
                    <div class="mt-1">
                        <x-form.text-input type="date" name="fecha_nacimiento" :value="old('fecha_nacimiento')" class="w-full" />    
                    </div>
                </div>

                {{-- Sección: Dirección --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mt-4 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-location-dot mr-2"></i>Dirección de Contacto
                    </h3>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="calle" :value="__('Calle o Avenida')"/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="calle" placeholder="Nombre de la calle" :value="old('calle')" class="w-full" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="no_exterior" :value="__('No. Ext.')"/>
                        <x-form.text-input type="text" name="no_exterior" :value="old('no_exterior')" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-form.input-label for="no_interior" :value="__('No. Int.')"/>
                        <x-form.text-input type="text" name="no_interior" :value="old('no_interior')" class="w-full mt-1" />
                    </div>
                </div>

                <div>
                    <x-form.input-label for="colonia" :value="__('Colonia / Fraccionamiento')"/>
                    <x-form.text-input type="text" name="colonia" :value="old('colonia')" class="w-full mt-1" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 col-span-1 md:col-span-2 gap-4">
                    <div>
                        <x-form.input-label for="codigo_postal" :value="__('C.P.')"/>
                        <x-form.text-input type="text" name="codigo_postal" :value="old('codigo_postal')" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-form.input-label for="ciudad" :value="__('Ciudad')"/>
                        <x-form.text-input type="text" name="ciudad" :value="old('ciudad')" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-form.input-label for="estado" :value="__('Estado')"/>
                        <x-form.text-input type="text" name="estado" :value="old('estado')" class="w-full mt-1" />
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="referencia" :value="__('Referencias del domicilio')"/>
                    <div class="mt-1">
                        <textarea name="referencia" rows="3" 
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3"
                            placeholder="Ej. Entre calle X y calle Y, frente a parque..."
                        >{{ old('referencia') }}</textarea>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('clientes.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Cancelar y volver
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-clientes">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cliente
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection