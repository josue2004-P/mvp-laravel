@extends('layouts.app')

@section('title', 'Registrar Tipo de Muestra')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Tipo de Muestra</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define los especímenes biológicos aceptados para los análisis (ej. Sangre total, Suero, Orina).</p>
    </div>

    <form id="form-tipo-muestra" action="{{ route('tipo_muestra.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Configuración Biológica" desc="El nombre debe ser claro para el personal de toma de muestras." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="flex items-center gap-4 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 mb-2">
                    <div class="h-12 w-12 rounded-lg bg-amber-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-vial text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900 dark:text-amber-400 uppercase tracking-tight">Gestión de Especímenes</h4>
                        <p class="text-xs text-amber-700 dark:text-amber-500/80">Este registro determinará los recipientes y condiciones de transporte necesarios para el análisis.</p>
                    </div>
                </div> --}}

                {{-- Campo Nombre --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre de la Muestra')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Sangre periférica, Plasma con Citrato, Heces"
                            class="w-full font-semibold uppercase tracking-tight"
                            :value="old('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Campo Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Instrucciones de Recolección (Opcional)')" />
                    <div class="mt-1">
                        <textarea 
                            name="descripcion" 
                            id="descripcion"
                            rows="4"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3 transition"
                            placeholder="Ej. Ayuno de 8 horas, recolectar en frasco estéril de 50ml..."
                        >{{ old('descripcion') }}</textarea>
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('tipo_muestra.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al listado
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-tipo-muestra">
                        <i class="fa-solid fa-vials mr-2"></i> Guardar Tipo
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection