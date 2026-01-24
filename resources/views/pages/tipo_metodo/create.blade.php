@extends('layouts.app')

@section('title', 'Nuevo Tipo de Método')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Nuevo Método Analítico</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Define las metodologías aplicadas en los análisis (ej. Enzimático, Colorimétrico, PCR).</p>
    </div>

    <form id="form-tipo-metodo" action="{{ route('tipo_metodo.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Configuración del Método" desc="El nombre debe identificar claramente el procedimiento técnico." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-6">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="flex items-center gap-4 p-4 rounded-xl bg-teal-50 dark:bg-teal-900/10 border border-teal-100 dark:border-teal-900/20">
                    <div class="h-12 w-12 rounded-lg bg-teal-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-microscope text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-teal-900 dark:text-teal-400 uppercase tracking-tight">Metodología de Laboratorio</h4>
                        <p class="text-xs text-teal-700 dark:text-teal-500/80">Este dato aparecerá en los reportes finales para validar la técnica utilizada.</p>
                    </div>
                </div> --}}

                {{-- Nombre del Método --}}
                <div>
                    <x-form.input-label for="nombre" :value="__('Nombre del Método')" required/>
                    <div class="mt-1">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="Ej. Espectrofotometría, Aglutinación..."
                            class="w-full font-semibold"
                            :value="old('nombre')"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                {{-- Descripción --}}
                <div>
                    <x-form.input-label for="descripcion" :value="__('Descripción del Procedimiento (Opcional)')" />
                    <div class="mt-1">
                      
                    <x-form.textarea-input 
                        name="descripcion" 
                        id="descripcion" 
                        rows="4" 
                        placeholder="Describe brevemente qué tipo de estudios o procesos abarca esta área..."
                    >
                        {{ old('descripcion')}}
                    </x-form.textarea-input>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('tipo_metodo.index') }}"
                        class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al catálogo
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-tipo-metodo">
                        <i class="fa-solid fa-vial-circle-check mr-2"></i> Registrar Método
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection