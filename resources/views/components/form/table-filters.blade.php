@props([
    'search' => null,
    'perPage' => null,
    'exportPdf' => null,
    'exportExcel' => null,
    'createRoute' => null,
    'title' => 'Registros'
])

<div class="rounded-3xl border border-gray-200 bg-white shadow-sm transition-all duration-300 dark:border-gray-800 dark:bg-gray-900/50">
    
    {{-- BARRA SUPERIOR PREMIUM --}}
    <div class="p-6">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            
            {{-- Título y Buscador Dinámico --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center flex-grow">
                <div>
                    <h3 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        {{ $title }}
                    </h3>
                </div>

                @if($search !== null)
                <div class="relative w-full sm:w-80 group">
                    <input 
                        type="text" 
                        wire:model.live.debounce.400ms="search" 
                        placeholder="Buscar..." 
                        class="h-[46px] w-full rounded-2xl border-gray-200 bg-gray-50/50 pl-12 pr-4 text-sm font-medium transition-all focus:bg-white focus:ring-4 focus:ring-indigo-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:focus:border-indigo-500/50"
                    >
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-base"></i>
                    </div>
                    {{-- Spinner de búsqueda sutil --}}
                    <div wire:loading wire:target="search" class="absolute right-4 top-1/2 -translate-y-1/2">
                        <div class="h-4 w-4 animate-spin rounded-full border-2 border-indigo-500 border-t-transparent"></div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Acciones Estratégicas --}}
            <div class="flex flex-wrap items-center gap-3">
                
                {{-- Controles de Exportación Glassmorphism --}}
                <div class="flex items-center gap-1 rounded-2xl bg-gray-100/80 p-1.5 dark:bg-white/[0.03] border border-gray-200 dark:border-gray-800">
                    @if($exportPdf)
                        <a href="{{ $exportPdf }}" target="_blank" 
                           class="flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 transition-all hover:bg-white hover:text-red-600 hover:shadow-sm dark:hover:bg-gray-800">
                            <i class="fa-solid fa-file-pdf"></i>
                        </a>
                    @endif
                    @if($exportExcel)
                        <a href="{{ $exportExcel }}" 
                           class="flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 transition-all hover:bg-white hover:text-green-600 hover:shadow-sm dark:hover:bg-gray-800">
                            <i class="fa-solid fa-file-excel"></i>
                        </a>
                    @endif
                </div>

                @if($perPage !== null)
                <div class="relative">
                    <select 
                        wire:model.live="perPage" 
                        class="h-[46px] appearance-none rounded-2xl border-gray-200 bg-white pl-4 pr-10 text-xs font-bold tracking-wide text-gray-600 transition-all focus:ring-4 focus:ring-indigo-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                    >
                        <option value="7">7 Filas</option>
                        <option value="25">25 Filas</option>
                        <option value="50">50 Filas</option>
                    </select>
                    <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
                @endif

                @if(isset($filters) && $filters->isNotEmpty())
                <button 
                    @click="$dispatch('toggle-filtros')" 
                    class="group inline-flex h-[46px] items-center rounded-2xl border border-indigo-100 bg-indigo-50/50 px-5 text-sm font-bold text-indigo-700 transition-all hover:bg-indigo-100 dark:border-indigo-500/20 dark:bg-indigo-500/5 dark:text-indigo-400"
                >
                    <i class="fa-solid fa-sliders mr-2.5 transition-transform group-hover:rotate-12"></i>
                    Filtros Avanzados
                </button>
                @endif

                @if($createRoute)
                    <x-form.button-primary 
                        tag="a" 
                        href="{{ $createRoute }}" 
                        class="h-[46px] !rounded-2xl px-6 shadow-lg shadow-indigo-500/20"
                    >
                        <i class="fa-solid fa-plus mr-2 text-xs"></i>
                        {{ __('Nuevo Registro') }}
                    </x-form.button-primary>
                @endif
            </div>
        </div>
    </div>

    {{-- PANEL DE FILTROS DESPLEGABLE --}}
    <div 
        x-data="{ show: false }" 
        @toggle-filtros.window="show = !show"
        x-show="show"
        x-cloak
        x-collapse
        class="border-t border-dashed border-gray-200 bg-gray-50/30 dark:border-gray-800 dark:bg-white/[0.01]"
    >
        <div class="p-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                {{ $filters }}
            </div>
        </div>
    </div>

    {{-- AREA DE TABLA CON LOADING STATE --}}
    <div class="relative min-h-[200px]">
        <div wire:loading.delay.longest class="absolute inset-0 z-20 flex items-center justify-center bg-white/60 backdrop-blur-[2px] dark:bg-gray-900/60 transition-all">
            <div class="flex flex-col items-center">
                <div class="h-10 w-10 animate-spin rounded-full border-4 border-indigo-600 border-t-transparent shadow-lg shadow-indigo-500/20"></div>
                <span class="mt-3 text-xs font-bold uppercase tracking-widest text-indigo-600 animate-pulse">Sincronizando...</span>
            </div>
        </div>
        
        <div class="overflow-x-auto overflow-y-hidden rounded-b-3xl">
            {{ $slot }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        const initSelect2 = () => {
            $('.select2-dynamic').each(function () {
                const $el = $(this);
                if ($el.data('select2')) return; // Evitar reinicio innecesario

                $el.select2({
                    placeholder: $el.data('placeholder') || 'Seleccionar...',
                    allowClear: true,
                    width: '100%',
                    containerCssClass: 'premium-select2'
                }).on('change', function() {
                    @this.set($el.data('model'), $(this).val());
                });
            });
        };

        initSelect2();
        Livewire.on('reinit-select2', () => setTimeout(initSelect2, 50));
    });
</script>
@endpush