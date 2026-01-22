@extends('layouts.app')

@section('title', 'Configuración de Análisis')

@section('content')
<form id="form-configuracion-analisis" action="{{ route('configuracion-analisis.store') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        {{-- SECCIÓN: CONFIGURACIÓN GENERAL --}}
        <div class="space-y-8">
            <x-common.component-card title="Configuración General" desc="Define el punto de partida del flujo de análisis.">
                <div class="py-4">
                    <x-form.input-label for="inicialEstatusId" :value="__('Estatus Inicial del Proceso')" required />
                    <x-form.input-select name="inicialEstatusId" id="inicialEstatusId" class="select2">
                        <option value="">Selecciona el estatus inicial...</option>
                        @foreach($estatus as $e)
                            <option value="{{ $e->id }}" 
                                {{ (old('inicialEstatusId', $configuracionExistente->inicial_estatus_id ?? '') == $e->id) ? 'selected' : '' }}>
                                {{ $e->nombre }}
                            </option>
                        @endforeach
                    </x-form.input-select>
                </div>

                <x-slot:footer>
                    <div class="flex justify-end">
                        <x-ui.button type="submit" class="shadow-lg shadow-indigo-500/20">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Configuración
                        </x-ui.button>
                    </div>
                </x-slot:footer>
            </x-common.component-card>

            {{-- SECCIÓN: FLUJO DE ESTATUS --}}
            <x-common.component-card title="Flujo de Transiciones" desc="Define qué estatus puede avanzar hacia cuáles.">
                <div class="container mx-auto py-2" x-data="{ activeFlow: $persist(null) }">
                    @foreach($estatus as $fila)
                        <div class="mb-3 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm">
                            <button type="button" @click="activeFlow = (activeFlow == {{ $fila->id }} ? null : {{ $fila->id }})"
                                class="w-full px-5 py-3 flex items-center justify-between transition-colors bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <div class="flex items-center gap-3">
                                    <div class="h-6 w-6 rounded-lg flex items-center justify-center text-[10px] font-bold shadow-sm" style="background-color: {{ $fila->color_fondo }}; color: {{ $fila->color_texto }}">
                                        {{ substr($fila->nombre, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-200 uppercase">{{ $fila->nombre }}</span>
                                </div>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-gray-400" :class="activeFlow == {{ $fila->id }} ? 'rotate-180 text-indigo-500' : ''"></i>
                            </button>

                            <div x-show="activeFlow == {{ $fila->id }}" x-collapse class="bg-gray-50/50 dark:bg-black/20 p-4 border-t border-gray-100 dark:border-gray-800">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Siguientes pasos permitidos:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($estatus as $col)
                                        @if($fila->id !== $col->id)
                                            <label class="flex items-center justify-between p-2.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 cursor-pointer hover:border-indigo-300 transition-all group">
                                                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-indigo-600 transition-colors uppercase">{{ $col->nombre }}</span>
                                                <input type="checkbox" name="flujo[{{ $fila->id }}][]" value="{{ $col->id }}"
                                                    {{ (isset($flujosActuales[$fila->id]) && in_array($col->id, $flujosActuales[$fila->id])) ? 'checked' : '' }}
                                                    class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-common.component-card>
        </div>

        {{-- COLUMNA DERECHA: PERMISOS POR PERFIL --}}
        <x-common.component-card title="Permisos por Perfil" desc="Asigna quién puede modificar cada estado.">
            <div class="space-y-4" x-data="{ activeAccordion: $persist(null) }">
                @foreach($perfiles as $perfil)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden shadow-sm">
                        <button type="button" @click="activeAccordion = (activeAccordion == {{ $perfil->id }} ? null : {{ $perfil->id }})"
                            class="w-full px-5 py-4 flex items-center justify-between bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="h-2 w-2 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(79,70,229,0.5)]"></div>
                                <span class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-tight">{{ $perfil->nombre }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-down transition-transform text-gray-400" :class="activeAccordion == {{ $perfil->id }} ? 'rotate-180 text-indigo-500' : ''"></i>
                        </button>

                        <div x-show="activeAccordion == {{ $perfil->id }}" x-collapse class="border-t border-gray-100 dark:border-gray-800">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-[10px] font-black text-gray-400 uppercase">Estatus</th>
                                        <th class="px-4 py-2 text-center text-[10px] font-black text-gray-400 uppercase">Modif.</th>
                                        <th class="px-4 py-2 text-center text-[10px] font-black text-gray-400 uppercase">Auto.</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-50 dark:divide-gray-800">
                                    @foreach($estatus as $e)
                                        @php
                                            $config = $configuracionPerfiles->where('perfil_id', $perfil->id)->where('estatus_id', $e->id)->first();
                                        @endphp
                                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-colors">
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded text-[10px] font-black uppercase shadow-sm border border-black/5" style="color: {{ $e->color_texto }}; background-color: {{ $e->color_fondo }}">
                                                    {{ $e->nombre }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="permisos[{{ $perfil->id }}][{{ $e->id }}][modificar]" value="1" 
                                                    {{ (isset($config) && $config->modificar == 1) ? 'checked' : '' }}
                                                    class="rounded text-indigo-600">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="permisos[{{ $perfil->id }}][{{ $e->id }}][automatico]" value="1" 
                                                    {{ (isset($config) && $config->automatico == 1) ? 'checked' : '' }}
                                                    class="rounded text-emerald-500">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-common.component-card>
    </div>
</form>
@endsection