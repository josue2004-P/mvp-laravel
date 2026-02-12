@props([
    'search' => null,
    'perPage' => null,
    'exportPdf' => null,
    'exportExcel' => null,
    'createRoute' => null,
    'title' => 'Registros'
])

<div class="rounded-lg border border-slate-300 bg-gray-50 shadow-sm transition-all duration-300 dark:border-slate-800 dark:bg-slate-900/50 overflow-hidden">
    
    {{-- BARRA SUPERIOR TÉCNICA --}}
    <div class="p-5 border-b border-slate-300 dark:border-slate-800 bg-gray-50 dark:bg-slate-900">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            
            {{-- Título y Buscador --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center flex-grow">
                <div>
                    <h3 class="text-lg font-black tracking-widest text-slate-950 dark:text-white uppercase">
                        {{ $title }}
                    </h3>
                </div>

                @if($search !== null)
                    <div class="relative w-full sm:w-80 group">
                        {{-- Solo pasamos el modelo y el placeholder; el diseño ya es el formal --}}
                        <x-form.text-input 
                                wire:model.live.debounce.400ms="search" 
                                placeholder="FILTRAR REGISTROS..." 
                                class="pl-10" 
                            />

                        {{-- Icono Lupa --}}
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#001f3f] dark:group-focus-within:text-white transition-colors pointer-events-none">
                            <i class="fa-solid fa-search text-[10px]"></i>
                        </div>

                        {{-- Spinner --}}
                        <div wire:loading wire:target="search" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <div class="h-3 w-3 animate-spin rounded-full border-2 border-[#001f3f] border-t-transparent dark:border-white"></div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Acciones Estratégicas --}}
            <div class="flex flex-wrap items-center gap-3">
                
                {{-- Controles de Exportación --}}
                @if($exportPdf || $exportExcel)
                    <div class="flex h-9 items-center gap-1 rounded border border-slate-300 bg-slate-50 px-1 dark:border-slate-700 dark:bg-slate-800">
                        @if($exportPdf)
                            <a href="{{ $exportPdf }}" target="_blank" 
                            class="flex h-7 w-7 items-center justify-center rounded text-slate-500 transition-all hover:bg-slate-900 hover:text-white dark:hover:bg-slate-100 dark:hover:text-slate-950">
                                <i class="fa-solid  fa-file-pdf text-[10px]"></i>
                            </a>
                        @endif
                        @if($exportExcel)
                            <a href="{{ $exportExcel }}" 
                            class="flex h-7 w-7 items-center justify-center rounded text-slate-500 transition-all hover:bg-slate-900 hover:text-white dark:hover:bg-slate-100 dark:hover:text-slate-950">
                                <i class="fa-solid fa-file-excel text-[10px]"></i>
                            </a>
                        @endif
                    </div>
                @endif

                @if($perPage !== null)
                <div class="relative">
                    <select wire:model.live="perPage" 
                        class="h-9 appearance-none rounded border border-slate-300 bg-slate-50 pl-3 pr-8 text-[10px] font-black uppercase tracking-widest text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <option value="7">7 REGISTROS</option>
                        <option value="25">25 REGISTROS</option>
                        <option value="50">50 REGISTROS</option>
                    </select>
                    <div class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fa-solid fa-chevron-down text-[8px]"></i>
                    </div>
                </div>
                @endif

                @if(isset($filters) && $filters->isNotEmpty())
                <button @click="$dispatch('toggle-filtros')" 
                    class="inline-flex h-9 items-center rounded border border-slate-300 bg-white px-4 text-[10px] font-black uppercase tracking-widest text-slate-900 hover:bg-slate-900 hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-white dark:hover:text-slate-900 transition-all">
                    <i class="fa-solid fa-sliders text-[9px] mr-2"></i>
                    FILTROS
                </button>
                @endif

                @if($createRoute)
                    <x-ui.button 
                        :href="$createRoute" 
                        variant="primary" 
                        size="md"
                    >
                        <x-slot:startIcon>
                            <i class="fa-solid text-lg fa-plus"></i>
                        </x-slot:startIcon>
                        
                        NUEVO REGISTRO
                    </x-ui.button>
                @endif
            </div>
        </div>
    </div>

    {{-- FILTROS DESPLEGABLES --}}
    <div x-data="{ show: false }" @toggle-filtros.window="show = !show" x-show="show" x-cloak x-collapse
        class="border-b border-slate-300 bg-slate-50/50 dark:border-slate-800">
        <div class="px-6 py-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-12">
                {{ $filters }}
            </div>
        </div>
    </div>

    {{-- ÁREA DE TABLA --}}
    <div class="relative min-h-[250px]">
        {{-- Loading Overlay --}}
        <div wire:loading.delay.longest class="absolute inset-0 z-50 flex items-center justify-center bg-white/60 backdrop-blur-[1px] dark:bg-slate-950/60">
            <div class="flex flex-col items-center">
                <div class="h-6 w-6 animate-spin rounded-full border-2 border-slate-950 border-t-transparent dark:border-white"></div>
                <span class="mt-3 text-[9px] font-black uppercase tracking-[0.3em] text-slate-950 dark:text-white">ACTUALIZANDO REGISTROS</span>
            </div>
        </div>
        
        <div class="overflow-x-auto p-6">
            {{ $slot }}
        </div>
    </div>
</div>