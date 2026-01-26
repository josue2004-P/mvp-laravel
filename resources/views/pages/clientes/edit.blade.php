@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex flex-wrap justify-between items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Actualizar Expediente</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Modificando el registro de: <span class="font-semibold text-indigo-600">{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('clientes.analisis.index', $cliente->id) }}" 
            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-indigo-200 dark:border-indigo-900 rounded-lg text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all shadow-sm">
                <i class="fa-solid fa-microscope mr-2"></i>
                Ver Historial de Análisis
                <span class="ml-2 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-full text-xs">
                    {{ $cliente->analisis_count ?? '0' }} {{-- Asumiendo que cargaste el conteo en el controlador --}}
                </span>
            </a>

            {{-- Badge de estado rápido existente --}}
            <span class="inline-flex items-center px-3 py-2 rounded-lg text-xs font-bold {{ $cliente->is_activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                <span class="w-2 h-2 mr-2 rounded-full {{ $cliente->is_activo ? 'bg-green-500' : 'bg-red-500' }}"></span>
                {{ $cliente->is_activo ? 'Activa' : 'Inactiva' }}
            </span>
        </div>
    </div>

    <form id="form-clientes" action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <x-common.component-card title="Edición de Datos" desc="Revisa cuidadosamente la información antes de guardar los cambios." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Sección: Información Personal --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-user-pen mr-2"></i>Información Personal
                    </h3>
                </div>

                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre(s)')" required/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="nombre" :value="old('nombre', $cliente->nombre)" class="w-full" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="apellido_paterno" :value="__('Apellido Paterno')" required/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="apellido_paterno" :value="old('apellido_paterno', $cliente->apellido_paterno)" class="w-full" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                </div>

                <div>
                    <x-form.input-label for="apellido_materno" :value="__('Apellido Materno')"/>
                    <div class="mt-1">
                        <x-form.text-input type="text" name="apellido_materno" :value="old('apellido_materno', $cliente->apellido_materno)" class="w-full" />    
                    </div>
                </div>

                <div>
                    <x-form.input-label for="email" :value="__('Correo Electrónico')"/>
                    <div class="mt-1">
                        <x-form.text-input type="email" name="email" :value="old('email', $cliente->email)" class="w-full lowercase font-medium" />    
                    </div>
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="edad" :value="__('Edad')" required/>
                        <x-form.text-input type="number" name="edad" :value="old('edad', $cliente->edad)" class="w-full mt-1" />    
                    </div>
                    <div>
                        <x-form.input-label for="sexo" :value="__('Sexo')" required/>
                        <x-form.input-select name="sexo" class="w-full mt-1">
                            <option value="MASCULINO" {{ old('sexo', $cliente->sexo) == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                            <option value="FEMENINO" {{ old('sexo', $cliente->sexo) == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                            <option value="OTRO" {{ old('sexo', $cliente->sexo) == 'OTRO' ? 'selected' : '' }}>Otro</option>
                        </x-form.input-select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')"/>
                        <x-form.text-input 
                            type="date" 
                            name="fecha_nacimiento" 
                            :value="old('fecha_nacimiento', $cliente->fecha_nacimiento ? $cliente->fecha_nacimiento->format('Y-m-d') : '')" 
                            class="w-full mt-1" 
                        />    
                    </div>
                    <div>
                        <x-form.input-label for="is_activo" :value="__('Estado de Cuenta')" />
                        <x-form.input-select name="is_activo" class="w-full mt-1">
                            <option value="1" {{ old('is_activo', $cliente->is_activo) == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_activo', $cliente->is_activo) == '0' ? 'selected' : '' }}>Inactivo</option>
                        </x-form.input-select>
                    </div>
                </div>

                {{-- Sección: Dirección --}}
                <div class="col-span-1 md:col-span-2 border-b border-gray-100 dark:border-gray-800 pb-2 mt-4 mb-2">
                    <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                        <i class="fa-solid fa-map-location-dot mr-2"></i>Ubicación y Domicilio
                    </h3>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="calle" :value="__('Calle o Avenida')"/>
                    <x-form.text-input type="text" name="calle" :value="old('calle', $cliente->calle)" class="w-full mt-1" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input-label for="no_exterior" :value="__('No. Ext.')"/>
                        <x-form.text-input type="text" name="no_exterior" :value="old('no_exterior', $cliente->no_exterior)" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-form.input-label for="no_interior" :value="__('No. Int.')"/>
                        <x-form.text-input type="text" name="no_interior" :value="old('no_interior', $cliente->no_interior)" class="w-full mt-1" />
                    </div>
                </div>

                <div>
                    <x-form.input-label for="colonia" :value="__('Colonia / Fraccionamiento')"/>
                    <x-form.text-input type="text" name="colonia" :value="old('colonia', $cliente->colonia)" class="w-full mt-1" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 col-span-1 md:col-span-2 gap-4">
                    <div>
                        <x-form.input-label for="codigo_postal" :value="__('C.P.')"/>
                        <x-form.text-input type="text" name="codigo_postal" :value="old('codigo_postal', $cliente->codigo_postal)" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-form.input-label for="ciudad" :value="__('Ciudad')"/>
                        <x-form.text-input type="text" name="ciudad" :value="old('ciudad', $cliente->ciudad)" class="w-full mt-1" />
                    </div>
                    <div>
                        <x-form.input-label for="estado" :value="__('Estado')"/>
                        <x-form.text-input type="text" name="estado" :value="old('estado', $cliente->estado)" class="w-full mt-1" />
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-form.input-label for="referencia" :value="__('Referencias internas e indicaciones')"/>
                    <div class="mt-1">
                        <x-form.textarea-input 
                            name="descripcion" 
                            id="descripcion" 
                            rows="4" 
                            placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                        >
                            {{ old('referencia', $cliente->referencia) }}
                        </x-form.textarea-input>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('clientes.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Descartar Cambios
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-clientes">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Actualizar Expediente
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection