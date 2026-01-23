@extends('layouts.app')

@section('title', 'Editar Análisis')

@section('content')
<div class="max-w-[1600px] mx-auto">
    {{-- Header dinámico --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-3xl bg-amber-500 flex items-center justify-center text-white shadow-xl shadow-amber-500/20">
                <i class="fa-solid fa-file-pen text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Editar Análisis #{{ $analisi->id }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Actualiza la muestra, especificaciones y resultados del estudio.</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('analisis.pdf', $analisi->id) }}" target="_blank" 
               class="inline-flex items-center px-5 py-2.5 rounded-xl bg-red-50 text-red-600 font-bold text-sm hover:bg-red-600 hover:text-white transition-all border border-red-200">
                <i class="fa-solid fa-file-pdf mr-2"></i> Reporte PDF
            </a>
            <x-ui.button type="submit" form="form-analisis" class="shadow-xl shadow-indigo-500/20">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
            </x-ui.button>
        </div>
    </div>

    <form id="form-analisis" action="{{ route('analisis.update', $analisi) }}" method="POST" class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        @csrf
        @method('PUT')

        {{-- COLUMNA IZQUIERDA: CONFIGURACIÓN TÉCNICA (8 COLS) --}}
        <div class="xl:col-span-8 space-y-8">
            
            <x-common.component-card title="Especificaciones del Análisis" desc="Control de muestra, método y flujo de trabajo.">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-2">
                    {{-- Cliente --}}
                    <div>
                        <x-form.input-label for="cliente_id" :value="__('Cliente')" required/>
                        <x-form.input-select name="cliente_id" class="select2">
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" @selected(old('cliente_id', $analisi->cliente_id) == $c->id)>{{ $c->getNombreCompletoAttribute() }}</option>
                            @endforeach
                        </x-form.input-select>
                    </div>
                    
                    {{-- Doctor --}}
                    <div>
                        <x-form.input-label for="doctor_id" :value="__('Médico Solicitante')" required/>
                        <x-form.input-select name="doctor_id" class="select2">
                            @foreach($doctores as $d)
                                <option value="{{ $d->id }}" @selected(old('doctor_id', $analisi->doctor_id) == $d->id)>{{ $d->getNombreCompletoAttribute() }}</option>
                            @endforeach
                        </x-form.input-select>
                    </div>

                    {{-- Gestión de Muestra y Estatus (Estilo destacado) --}}
                    <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 dark:bg-white/[0.02] p-5 rounded-2xl border border-gray-100 dark:border-gray-800">
                        {{-- Tipo de Muestra (Sincronizado con migración) --}}
                        <div>
                            <x-form.input-label for="tipo_muestra_id" :value="__('Tipo de Muestra')" class="font-black text-indigo-600 dark:text-indigo-400" />
                            <x-form.input-select name="tipo_muestra_id" id="tipo_muestra_id" class="select2">
                                <option value="">-- Seleccione una muestra (Opcional) --</option>
                                @foreach($tiposMuestra as $tm)
                                    <option value="{{ $tm->id }}" @selected(old('tipo_muestra_id', $analisi->tipo_muestra_id) == $tm->id)>{{ $tm->nombre }}</option>
                                @endforeach
                            </x-form.input-select>
                        </div>

                        {{-- Estatus / Flujo --}}
                        <div>
                            <x-form.input-label for="estatus_id" :value="__('Estatus del Análisis')" class="font-black text-indigo-600 dark:text-indigo-400" />
                            <x-form.input-select 
                                name="estatus_id" 
                                id="estatus_id"
                                class="select2 {{ !$puedeModificarActual ? 'pointer-events-none opacity-60' : '' }}"
                            >
                                <option value="{{ $analisi->estatus_id }}" selected>{{ $analisi->estatus->nombre }} (Actual)</option>
                                @foreach($estatusPermitidos as $permitido)
                                    <option value="{{ $permitido->id }}">{{ $permitido->descripcion }}</option>
                                @endforeach
                            </x-form.input-select>
                        </div>
                    </div>

                    {{-- Especificaciones Técnicas --}}
                    <div>
                        <x-form.input-label for="tipo_analisis_id" :value="__('Tipo de Análisis')" required/>
                        <x-form.input-select name="tipo_analisis_id" class="select2">
                            @foreach($tiposAnalisis as $t)
                                <option value="{{ $t->id }}" @selected(old('tipo_analisis_id', $analisi->tipo_analisis_id) == $t->id)>{{ $t->nombre }}</option>
                            @endforeach
                        </x-form.input-select>
                    </div>

                    <div>
                        <x-form.input-label for="tipo_metodo_id" :value="__('Método')" required/>
                        <x-form.input-select name="tipo_metodo_id" class="select2">
                            <option value="">-- Seleccione una muestra (Opcional) --</option>
                            @foreach($tiposMetodo as $tm)
                                <option value="{{ $tm->id }}" @selected(old('tipo_metodo_id', $analisi->tipo_metodo_id) == $tm->id)>{{ $tm->nombre }}</option>
                            @endforeach
                        </x-form.input-select>
                    </div>

                    <div class="col-span-2">
                        <x-form.input-label for="nota" :value="__('Observaciones Clínicas')"/>
                        <x-form.text-input name="nota" :value="old('nota', $analisi->nota)" placeholder="Escribe notas relevantes..." />
                    </div>
                </div>
            </x-common.component-card>

            <x-common.component-card title="Captura de Resultados" desc="Haz clic en las cabeceras para expandir o contraer las categorías.">
                @php
                    $hemogramasPorCategoria = $analisi->tipoAnalisis
                        ->parametrosHemograma
                        ->groupBy(fn($h) => $h->categoria->nombre ?? 'General');
                @endphp

                {{-- Contenedor con estado de Alpine.js --}}
                {{-- activeCategory: almacena el nombre de la categoría abierta. Puedes usar null para que todos inicien cerrados --}}
                <div class="space-y-4" x-data="{ activeCategory: '{{ $hemogramasPorCategoria->keys()->first() }}' }">
                    @foreach($hemogramasPorCategoria as $categoria => $hemogramas)
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] overflow-hidden transition-all duration-300"
                            :class="activeCategory === '{{ $categoria }}' ? 'ring-1 ring-indigo-500/30 shadow-lg' : ''">
                            
                            {{-- Cabecera / Botón de apertura --}}
                            <button type="button" 
                                @click="activeCategory = (activeCategory === '{{ $categoria }}' ? null : '{{ $categoria }}')"
                                class="w-full px-5 py-4 flex justify-between items-center bg-white/[0.03] hover:bg-white/[0.05] transition-colors text-left focus:outline-none">
                                
                                <div class="flex items-center gap-3">
                                    {{-- Indicador visual de color --}}
                                    <div class="h-4 w-1 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.5)]"></div>
                                    <h4 class="text-xs font-black uppercase tracking-widest text-white/90">
                                        {{ $categoria }}
                                    </h4>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">
                                        {{ $hemogramas->count() }} ítems
                                    </span>
                                    {{-- Icono con rotación --}}
                                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 transition-transform duration-300"
                                    :class="activeCategory === '{{ $categoria }}' ? 'rotate-180 text-indigo-400' : ''"></i>
                                </div>
                            </button>

                            {{-- Contenido colapsable --}}
                            <div x-show="activeCategory === '{{ $categoria }}'" 
                                x-collapse {{-- Requiere el plugin Collapse de Alpine.js --}}
                                x-cloak>
                                <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-3 border-t border-white/5 bg-black/20">
                                    @foreach($hemogramas as $hemograma)
                                        @php
                                            $valorPrevio = $analisi->hemogramas->firstWhere('id', $hemograma->id)?->pivot->resultado;
                                        @endphp
                                        <div class="flex items-center justify-between p-3 rounded-xl border border-white/5 bg-white/[0.02] hover:bg-white/[0.04] transition-all group">
                                            <div class="flex flex-col">
                                                <span class="text-[11px] font-black text-white/90 uppercase group-hover:text-indigo-400 transition-colors">
                                                    {{ $hemograma->nombre }}
                                                </span>
                                                <div class="flex items-center gap-1.5 mt-0.5">
                                                    <span class="text-[9px] font-bold text-gray-600 uppercase">Ref:</span>
                                                    <span class="text-[9px] font-mono font-bold text-gray-400">{{ $hemograma->referencia ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="relative">
                                                <input type="text" 
                                                    name="resultados[{{ $hemograma->id }}]" 
                                                    value="{{ old('resultados.'.$hemograma->id, $valorPrevio) }}"
                                                    placeholder="0.00"
                                                    class="w-24 text-right font-mono text-sm font-bold border-gray-700 bg-gray-950/50 text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all p-2 shadow-inner">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-common.component-card>
        </div>

        {{-- COLUMNA DERECHA: ESTADO VISUAL (4 COLS) --}}
        <div class="xl:col-span-4 space-y-6">
            <x-common.component-card title="Estado del Análisis">
                <div class="flex flex-col items-center text-center p-4">
                    <div class="mb-4 relative group">
                        <div class="absolute -inset-1 bg-indigo-500 rounded-2xl blur opacity-10 group-hover:opacity-25 transition duration-1000"></div>
                        <span class="relative px-6 py-2 rounded-2xl text-xs font-black uppercase tracking-[0.2em] shadow-lg border border-black/5 inline-block"
                              style="background-color: {{ $analisi->estatus->color_fondo }}; color: {{ $analisi->estatus->color_texto }}">
                            {{ $analisi->estatus->nombre }}
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Creado: {{ $analisi->created_at->format('d/m/Y H:i') }}</p>
                    <p class="text-[10px] text-gray-500 font-medium mt-1">Ult. Act: {{ $analisi->updated_at->format('d/m/Y H:i') }}</p>
                </div>

                <x-slot:footer>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('analisis.index') }}" class="w-full text-center py-2.5 text-xs font-bold text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Cancelar y Volver
                        </a>
                    </div>
                </x-slot:footer>
            </x-common.component-card>
        </div>
    </form>
</div>
@endsection