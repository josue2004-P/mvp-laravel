@extends('layouts.app')

@section('title', 'Configurar Perfil de Análisis')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Encabezado Externo --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Configuración de Perfil</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Editando el grupo: <span class="font-bold text-purple-600 dark:text-purple-400">{{ $tipoAnalisis->nombre }}</span>
        </p>
    </div>

    <form id="form-tipo-analisis" action="{{ route('tipo_analisis.update', $tipoAnalisis) }}" method="POST" 
        x-data="{ 
            abierto: {},
            toggleCategoria(categoria, ids) {
                {{-- Lógica para seleccionar/deseleccionar todos los checkboxes de una categoría --}}
                let checkboxes = document.querySelectorAll('.check-' + categoria);
                let todosMarcados = Array.from(checkboxes).every(c => c.checked);
                checkboxes.forEach(c => c.checked = !todosMarcados);
            }
        }">
        @csrf
        @method('PUT')

        <x-common.component-card title="Estructura del Análisis" desc="Selecciona los componentes que integrarán este perfil diagnóstico." class="shadow-theme-md">
            
            <div class="grid grid-cols-1 gap-8">
                
                {{-- Sección Visual Informativa --}}
                {{-- <div class="flex items-center gap-4 p-4 rounded-xl bg-purple-50 dark:bg-purple-900/10 border border-purple-100 dark:border-purple-900/20">
                    <div class="h-12 w-12 rounded-lg bg-purple-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-layer-group text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-purple-900 dark:text-purple-400 uppercase tracking-tight">Personalización de Perfiles</h4>
                        <p class="text-xs text-purple-700 dark:text-purple-500/80">Los parámetros seleccionados se imprimirán automáticamente al solicitar este tipo de análisis.</p>
                    </div>
                </div> --}}

                {{-- Campo Nombre --}}
                <div class="max-w-xl">
                    <x-form.input-label for="nombre" :value="__('Nombre del Perfil Analítico')" required />
                    <div class="mt-1">
                        <x-form.text-input
                            type="text"
                            name="nombre"
                            placeholder="Ej. Perfil Pre-Operatorio"
                            class="w-full font-bold text-lg"
                            :value="old('nombre', $tipoAnalisis->nombre)" 
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <hr class="border-gray-100 dark:border-gray-800">

                {{-- Acordeones de Parámetros --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Parámetros Disponibles</h3>
                        <span class="text-xs text-gray-400 italic">Haz clic en la categoría para expandir</span>
                    </div>

                    @foreach($hemogramas->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría') as $categoria => $hemos)
                        @php $slug = Str::slug($categoria); @endphp
                        <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden bg-white dark:bg-gray-900 transition-all shadow-sm">
                            
                            {{-- Header del Acordeón --}}
                            <div class="w-full flex items-center px-5 py-4 bg-gray-50/50 dark:bg-white/[0.02]">
                                <button
                                    type="button"
                                    class="flex-1 flex items-center gap-3 text-left transition"
                                    @click="abierto['{{ $slug }}'] = !abierto['{{ $slug }}']"
                                >
                                    <i class="fa-solid fa-chevron-right text-[10px] text-purple-500 transition-transform duration-300" 
                                       :class="abierto['{{ $slug }}'] ? 'rotate-90' : ''"></i>
                                    <span class="font-bold text-gray-700 dark:text-gray-200">{{ $categoria }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-lg bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 font-bold">
                                        {{ $hemos->count() }}
                                    </span>
                                </button>

                                {{-- Botón Seleccionar Todo --}}
                                <button 
                                    type="button"
                                    @click="toggleCategoria('{{ $slug }}')"
                                    class="text-[10px] font-bold uppercase text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors"
                                >
                                    Seleccionar todo
                                </button>
                            </div>

                            {{-- Grid de Checkboxes --}}
                            <div x-show="abierto['{{ $slug }}']" x-collapse>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 border-t border-gray-100 dark:border-gray-800">
                                    @foreach($hemos as $hemograma)
                                        <label class="relative flex items-center p-4 rounded-xl border border-gray-100 dark:border-gray-800 cursor-pointer transition-all hover:border-purple-200 hover:bg-purple-50/30 dark:hover:bg-purple-900/10 group shadow-sm">
                                            <input
                                                type="checkbox"
                                                name="hemogramas[]"
                                                value="{{ $hemograma->id }}"
                                                class="check-{{ $slug }} h-5 w-5 rounded-lg border-gray-300 dark:border-gray-600 text-purple-600 focus:ring-purple-500 dark:bg-gray-800 transition-all"
                                                {{ in_array($hemograma->id, $tipoAnalisis->parametrosHemograma->pluck('id')->toArray()) ? 'checked' : '' }}
                                            >
                                            <div class="ml-4 flex flex-col">
                                                <span class="text-sm font-bold text-gray-700 dark:text-gray-200 group-hover:text-purple-600 transition-colors">
                                                    {{ $hemograma->nombre }}
                                                </span>
                                                <span class="text-[10px] text-gray-400">
                                                    {{ $hemograma->unidad->nombre ?? 's/u' }}
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('tipo_analisis.index') }}" 
                       class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-xmark mr-2"></i> Cancelar edición
                    </a>
                    
                    <x-ui.button size="sm" type="submit">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                    </x-ui.button>
                </div>
            </x-slot:footer>

        </x-common.component-card>
    </form>
</div>
@endsection