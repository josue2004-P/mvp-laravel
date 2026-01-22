@extends('layouts.app')

@section('title', 'Configuracion Analisis')

@section('content')


<form id="form-configuracion-analisis" action="{{ route('configuracion-analisis.store') }}" method="POST" >
    @csrf
    <div class=" text-white grid grid-cols-1 md:grid-cols-2">
        <x-common.component-card title="Configuracion general" class="max-w-2xl h-fit">
            <div class="max-w-2xl text-gray-800 dark:text-white">
                <x-form.input-label for="inicialEstatusId" :value="__('Estatus Inicial')" />
                <x-form.input-select 
                    name="inicialEstatusId" 
                    id="inicialEstatusId"
                    :messages="$errors->get('inicialEstatusId')"
                    class="select2"
                >
                    <option value="">Selecciona un estatus</option>
                    @foreach($estatus as $e)
                        <option value="{{ $e->id }}" 
                            {{ (old('inicialEstatusId', $configuracionExistente->inicialEstatusId ?? '') == $e->id) ? 'selected' : '' }}>
                            {{ $e->descripcion }}
                        </option>
                    @endforeach
                </x-form.input-select>
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-ui.button size="sm" type="submit" form="form-configuracion-analisis">
                        Guardar
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>

        <x-common.component-card title="Perfiles con Permiso Modificar Estatus" class="max-w-2xl">
            <div class="container mx-auto py-8" 
                wire:ignore 
                x-data="{ activeAccordion: $persist(null).as('config_analisis_acordeon') }">
                
                @foreach($perfiles as $perfil)
                    <div class="mb-4 bg-white dark:bg-dark-900 shadow-theme-xs rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden transition-colors duration-200">
                        
                        {{-- Botón del Acordeón --}}
                        <button 
                            type="button"
                            class="w-full px-6 py-4 flex items-center justify-between transition-all focus:outline-none focus:ring-3 focus:ring-brand-500/10"
                            {{-- Usamos == para comparar el ID (string vs int de localStorage) --}}
                            :class="activeAccordion == {{ $perfil->id }} 
                                ? 'bg-gray-50 dark:bg-gray-800/80' 
                                : 'bg-white dark:bg-gray-900'"
                            @click="activeAccordion = (activeAccordion == {{ $perfil->id }} ? null : {{ $perfil->id }})"
                        >
                            <div class="flex items-center gap-3">
                                <div class="h-5 w-1 bg-brand-500 rounded-full shadow-[0_0_8px_rgba(var(--color-brand-500),0.4)]"></div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wide">
                                    Perfil: {{ $perfil->nombre }}
                                </h3>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-medium text-gray-400 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-md">
                                    ID: {{ $perfil->id }}
                                </span>
                                <svg 
                                    class="w-5 h-5 transition-transform duration-300" 
                                    :class="activeAccordion == {{ $perfil->id }} ? 'rotate-180 text-brand-500' : 'text-gray-400 dark:text-gray-500'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        {{-- Contenido del Acordeón --}}
                        <div 
                            x-show="activeAccordion === {{ $perfil->id }}" 
                            x-collapse
                            x-cloak
                            class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900"
                        >
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                                    <thead class="bg-gray-50/30 dark:bg-gray-800/50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Estatus</th>
                                            <th scope="col" class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-l border-gray-200 dark:border-gray-800">Modificar</th>
                                            <th scope="col" class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-l border-gray-200 dark:border-gray-800">Automático</th>
                                        </tr>
                                    </thead>
                                    {{-- Forzamos el fondo oscuro en el body para evitar el blanco de las imágenes --}}
                                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                                        @foreach($estatus as $e)
                                            @php
                                                $config = $configuracionPerfiles->where('perfilId', $perfil->id)->where('estatusId', $e->id)->first();
                                            @endphp
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1.5 rounded-md text-[11px] font-black shadow-theme-xs inline-block uppercase border border-black/5 dark:border-white/5" 
                                                        style="color: {{ $e->colorTexto }}; background-color: {{ $e->colorFondo }};">
                                                        {{ $e->nombreCorto }}
                                                    </span>
                                                </td>
                                                
                                                <td class="px-6 py-4 text-center border-l border-gray-100 dark:border-gray-800">
                                                    <x-form.checkbox-input 
                                                        name="permisos[{{ $perfil->id }}][{{ $e->id }}][modificar]" 
                                                        value="1"
                                                        :checked="isset($config) && $config->modificar == 1"
                                                        {{-- Añadimos clases para que el input no se pierda en el fondo --}}
                                                        class="dark:bg-gray-800 dark:border-gray-700"
                                                    />
                                                </td>

                                                <td class="px-6 py-4 text-center border-l border-gray-100 dark:border-gray-800">
                                                    <x-form.checkbox-input 
                                                        name="permisos[{{ $perfil->id }}][{{ $e->id }}][automatico]" 
                                                        value="1"
                                                        :checked="isset($config) && $config->automatico == 1"
                                                        class="dark:bg-gray-800 dark:border-gray-700"
                                                    />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-common.component-card>

        <x-common.component-card title="Configuración de Flujo de Análisis" class="max-w-4xl mt-6">
            {{-- Contenedor principal con wire:ignore para evitar conflictos con Livewire --}}
            <div class="container mx-auto py-4" 
                wire:ignore 
                x-data="{ activeFlow: $persist(null).as('config_flujo_acordeon') }">
                
                @foreach($estatus as $fila)
                    <div class="mb-3 bg-white dark:bg-dark-900 shadow-theme-xs rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden transition-colors duration-200">
                        
                        {{-- Botón del Acordeón (Estatus Origen) --}}
                        <button 
                            type="button"
                            class="w-full px-6 py-4 flex items-center justify-between transition-all focus:outline-none focus:ring-3 focus:ring-brand-500/10"
                            {{-- Mismo comportamiento de color que en perfiles: cambia según si está activo --}}
                            :class="activeFlow == {{ $fila->id }} 
                                ? 'bg-gray-50 dark:bg-gray-800/80' 
                                : 'bg-white dark:bg-gray-900'"
                            @click="activeFlow = (activeFlow == {{ $fila->id }} ? null : {{ $fila->id }})"
                        >
                            <div class="flex items-center gap-3">
                                {{-- Indicador de color lateral usando el color del estatus --}}
                                <div class="h-5 w-1 rounded-full shadow-[0_0_8px_rgba(var(--color-brand-500),0.4)]" 
                                    style="background-color: {{ $fila->colorFondo }};"></div>
                                    
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wide">
                                    {{ $fila->nombreCorto }}
                                </h3>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                {{-- Etiqueta de Origen con estilo sutil --}}
                                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded uppercase tracking-widest">
                                    Origen
                                </span>
                                
                                {{-- Flecha con rotación e indicador de color activo --}}
                                <svg 
                                    class="w-5 h-5 transition-transform duration-300" 
                                    :class="activeFlow == {{ $fila->id }} ? 'rotate-180 text-brand-500' : 'text-gray-400 dark:text-gray-500'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        {{-- Contenido del Acordeón (Estatus Destinos Permitidos) --}}
                        <div 
                            x-show="activeFlow == {{ $fila->id }}" 
                            x-collapse
                            x-cloak
                            {{-- bg-white para claro y un tono muy oscuro para el modo dark --}}
                            class="border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-950"
                        >
                            <div class="p-4">
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase font-bold mb-3 tracking-widest">
                                    Selecciona los estatus destino permitidos:
                                </p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($estatus as $col)
                                        {{-- Evitamos que un estatus fluya a sí mismo --}}
                                        @if($fila->id !== $col->id)
                                            {{-- Ajustamos el borde y el hover para modo oscuro --}}
                                            <div class="flex items-center justify-between p-2.5 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900/20 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                                <div class="flex items-center gap-2">
                                                    {{-- Indicador de color circular --}}
                                                    <span class="w-2 h-2 rounded-full shadow-sm" style="background-color: {{ $col->colorFondo }};"></span>
                                                    {{-- Texto adaptable --}}
                                                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-tight">
                                                        {{ $col->nombreCorto }}
                                                    </span>
                                                </div>
                                                
                                                {{-- Checkbox con clases para dark mode --}}
                                                <x-form.checkbox-input 
                                                    name="flujo[{{ $fila->id }}][]" 
                                                    value="{{ $col->id }}"
                                                    :checked="isset($flujosActuales[$fila->id]) && in_array($col->id, $flujosActuales[$fila->id])"
                                                    class="dark:bg-gray-800 dark:border-gray-700"
                                                />
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-common.component-card>
    </div>
</form>
@endsection