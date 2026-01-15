@extends('layouts.app')

@section('title', 'Configuracion Analisis')

@section('content')


<form id="form-configuracion-analisis" action="{{ route('configuracion-analisis.store') }}" method="POST" >
    @csrf
    <div class=" text-white grid grid-cols-1 md:grid-cols-2">
        <x-common.component-card title="Configuracion general" class="max-w-2xl">
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
                            {{ (old('inicialEstatusId', $modeloExistente->inicialEstatusId ?? '') == $e->id) ? 'selected' : '' }}>
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
            <div class="container mx-auto py-8" x-data="{ activeAccordion: null }">
                @foreach($perfiles as $perfil)
                    <div class="mb-4 bg-white dark:bg-dark-900 shadow-theme-xs rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden transition-colors duration-200">
                        
                        <button 
                            type="button"
                            class="w-full px-6 py-4 flex items-center justify-between transition-all focus:outline-hidden focus:ring-3 focus:ring-brand-500/10"
                            :class="activeAccordion === {{ $perfil->id }} ? 'bg-gray-50 dark:bg-gray-800/50' : 'bg-transparent'"
                            @click="activeAccordion = (activeAccordion === {{ $perfil->id }} ? null : {{ $perfil->id }})"
                        >
                            <div class="flex items-center gap-3">
                                <div class="h-5 w-1 bg-brand-500 rounded-full shadow-[0_0_8px_rgba(var(--color-brand-500),0.4)]"></div>
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white/90 uppercase tracking-wide">
                                    Perfil: {{ $perfil->nombre }}
                                </h3>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <span class="text-xs font-medium text-gray-400 dark:text-white/30 bg-gray-100 dark:bg-dark-800 px-2 py-0.5 rounded-md">
                                    ID: {{ $perfil->id }}
                                </span>
                                <svg 
                                    class="w-5 h-5 transition-transform duration-300" 
                                    :class="activeAccordion === {{ $perfil->id }} ? 'rotate-180 text-brand-500' : 'text-gray-400 dark:text-white/20'"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        <div 
                            x-show="activeAccordion === {{ $perfil->id }}" 
                            x-collapse
                            x-cloak
                            class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-dark-950"
                        >
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                                    <thead class="bg-gray-50/30 dark:bg-gray-900/40">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-[10px] font-bold text-gray-500 dark:text-white/30 uppercase tracking-widest">Estatus</th>
                                            <th scope="col" class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 dark:text-white/30 uppercase tracking-widest border-l border-gray-200 dark:border-gray-800">Modificar</th>
                                            <th scope="col" class="px-6 py-3 text-center text-[10px] font-bold text-gray-500 dark:text-white/30 uppercase tracking-widest border-l border-gray-200 dark:border-gray-800">Automático</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                        @foreach($estatus as $e)
                                            <tr class="hover:bg-brand-500/[0.03] dark:hover:bg-brand-500/[0.05] transition-colors">
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
                                                        class="dark:bg-gray-900 dark:border-gray-700 focus:ring-brand-500/20"
                                                    />
                                                </td>
                                                <td class="px-6 py-4 text-center border-l border-gray-100 dark:border-gray-800">
                                                    <x-form.checkbox-input 
                                                        name="permisos[{{ $perfil->id }}][{{ $e->id }}][automatico]" 
                                                        value="1"
                                                        class="dark:bg-gray-900 dark:border-gray-700 focus:ring-brand-500/20"
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
    </div>
</form>
@endsection