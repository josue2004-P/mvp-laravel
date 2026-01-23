@extends('layouts.app')

@section('title', 'Configuración de Análisis')

@section('content')
<form id="form-configuracion-analisis" action="{{ route('configuracion-analisis.store') }}" method="POST">
    @csrf
    
    <div class="max-w-7xl mx-auto space-y-8">
        {{-- Header Principal --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Panel de Configuración</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Gestiona el comportamiento global, permisos de perfiles y el flujo lógico de los análisis.</p>
            </div>
            <x-ui.button type="submit" form="form-configuracion-analisis" class="shadow-xl shadow-indigo-500/20 group">
                <i class="fa-solid fa-cloud-arrow-up mr-2 group-hover:animate-bounce"></i> 
                Guardar Cambios Globales
            </x-ui.button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- COLUMNA IZQUIERDA: GENERAL Y FLUJO --}}
            <div class="lg:col-span-7 space-y-8">
                
                {{-- Configuración General --}}
                <x-common.component-card title="Estatus Inicial" desc="Punto de partida para todo nuevo análisis creado.">
                    <div class="py-2">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
                            <x-form.input-select name="inicialEstatusId" id="inicialEstatusId" class="select2 relative">
                                <option value="">Selecciona el estatus inicial...</option>
                                @foreach($estatus as $e)
                                    <option value="{{ $e->id }}" 
                                        {{ (old('inicialEstatusId', $configuracionExistente->inicial_estatus_id ?? '') == $e->id) ? 'selected' : '' }}>
                                        {{ $e->nombre }}
                                    </option>
                                @endforeach
                            </x-form.input-select>
                        </div>
                    </div>
                </x-common.component-card>

                {{-- Flujo de Transiciones --}}
                <x-common.component-card title="Matriz de Flujo" desc="Define los destinos permitidos para cada estatus de origen.">
                    <div x-data="{ activeFlow: $persist(null) }" class="space-y-3">
                        @foreach($estatus as $fila)
                            <div class="group border border-gray-100 dark:border-gray-800 rounded-2xl transition-all duration-300 shadow-sm"
                                 :class="activeFlow == {{ $fila->id }} ? 'ring-2 ring-indigo-500/10 border-indigo-200' : 'hover:border-gray-300'">
                                
                                <button type="button" @click="activeFlow = (activeFlow == {{ $fila->id }} ? null : {{ $fila->id }})"
                                    class="w-full px-5 py-4 flex items-center justify-between bg-white dark:bg-gray-900 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-xl flex items-center justify-center text-xs font-black shadow-inner" 
                                             style="background-color: {{ $fila->color_fondo }}; color: {{ $fila->color_texto }}">
                                            {{ substr($fila->nombre, 0, 2) }}
                                        </div>
                                        <div class="text-left">
                                            <span class="block text-xs font-black text-gray-400 uppercase tracking-widest">Origen</span>
                                            <span class="text-sm font-bold text-gray-800 dark:text-white uppercase">{{ $fila->nombre }}</span>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-circle-chevron-down transition-transform duration-500 text-gray-300 text-lg" 
                                       :class="activeFlow == {{ $fila->id }} ? 'rotate-180 text-indigo-500' : ''"></i>
                                </button>

                                <div x-show="activeFlow == {{ $fila->id }}" x-collapse x-cloak>
                                    <div class="p-6 pt-0 bg-gray-50/30 dark:bg-white/[0.01] rounded-b-2xl border-t border-gray-50 dark:border-gray-800">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                                            @foreach($estatus as $col)
                                                @if($fila->id !== $col->id)
                                                    <label class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 cursor-pointer hover:shadow-md transition-all group/item">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-2 h-2 rounded-full" style="background-color: {{ $col->color_fondo }}"></div>
                                                            <span class="text-xs font-bold text-gray-600 dark:text-gray-300 group-hover/item:text-indigo-600 uppercase">{{ $col->nombre }}</span>
                                                        </div>
                                                        <input type="checkbox" name="flujo[{{ $fila->id }}][]" value="{{ $col->id }}"
                                                            {{ (isset($flujosActuales[$fila->id]) && in_array($col->id, $flujosActuales[$fila->id])) ? 'checked' : '' }}
                                                            class="rounded-lg border-gray-300 text-indigo-600 focus:ring-indigo-500 h-5 w-5">
                                                    </label>
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

            {{-- COLUMNA DERECHA: PERMISOS --}}
            <div class="lg:col-span-5 space-y-8">
                <x-common.component-card title="Seguridad por Perfil" desc="Control de acceso y automatización.">
                    <div x-data="{ activeAccordion: $persist(null) }" class="space-y-4">
                        @foreach($perfiles as $perfil)
                            <div class="border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden bg-white dark:bg-gray-900 shadow-sm transition-all"
                                 :class="activeAccordion == {{ $perfil->id }} ? 'ring-2 ring-emerald-500/10' : ''">
                                
                                <button type="button" @click="activeAccordion = (activeAccordion == {{ $perfil->id }} ? null : {{ $perfil->id }})"
                                    class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                                            <i class="fa-solid fa-user-shield text-xs"></i>
                                        </div>
                                        <span class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-tight">{{ $perfil->nombre }}</span>
                                    </div>
                                    <i class="fa-solid fa-angle-down transition-transform text-gray-300" :class="activeAccordion == {{ $perfil->id }} ? 'rotate-180 text-emerald-500' : ''"></i>
                                </button>

                                <div x-show="activeAccordion == {{ $perfil->id }}" x-collapse x-cloak>
                                    <div class="overflow-x-auto border-t border-gray-50 dark:border-gray-800">
                                        <table class="min-w-full">
                                            <thead class="bg-gray-50/50 dark:bg-gray-800/50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-[9px] font-black text-gray-400 uppercase tracking-tighter">Estatus</th>
                                                    <th class="px-4 py-2 text-center text-[9px] font-black text-gray-400 uppercase tracking-tighter">Modificar</th>
                                                    <th class="px-4 py-2 text-center text-[9px] font-black text-gray-400 uppercase tracking-tighter">Auto</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                                @foreach($estatus as $e)
                                                    @php
                                                        $config = $configuracionPerfiles->where('perfil_id', $perfil->id)->where('estatus_id', $e->id)->first();
                                                    @endphp
                                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-emerald-500/5 transition-colors">
                                                        <td class="px-4 py-3">
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $e->color_fondo }}"></div>
                                                                <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300 uppercase">{{ $e->nombre }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3 text-center">
                                                            <input type="checkbox" name="permisos[{{ $perfil->id }}][{{ $e->id }}][modificar]" value="1" 
                                                                {{ (isset($config) && $config->modificar == 1) ? 'checked' : '' }}
                                                                class="rounded-md border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                                        </td>
                                                        <td class="px-4 py-3 text-center">
                                                            <input type="checkbox" name="permisos[{{ $perfil->id }}][{{ $e->id }}][automatico]" value="1" 
                                                                {{ (isset($config) && $config->automatico == 1) ? 'checked' : '' }}
                                                                class="rounded-md border-gray-300 text-emerald-500 focus:ring-emerald-500 h-4 w-4">
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
            </div>
        </div>
    </div>
</form>
@endsection