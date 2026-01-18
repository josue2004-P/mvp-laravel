@props([
    'search' => null,
    'perPage' => null,
    'exportPdf' => null,
    'exportExcel' => null,
    'createRoute' => null,
    'title' => 'Registros'
])

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-sm overflow-hidden">
    
    {{-- BARRA SUPERIOR ESTRUCUTRADA --}}
    <div class="p-5 border-b border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            
            {{-- Título y Buscador --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 flex-grow">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $title }}</h3>
                </div>

                @if($search !== null)
                <div class="relative w-full sm:w-72 group">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Buscar en registros..." 
                        class="h-[42px] w-full rounded-xl border-gray-200 bg-gray-50/50 pl-11 pr-4 text-sm transition-all focus:bg-white focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-700 dark:bg-gray-900/50 dark:text-white dark:focus:border-indigo-500"
                    >
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>
                </div>
                @endif
            </div>

            {{-- Acciones y Controles --}}
            <div class="flex flex-wrap items-center gap-3">
                
                {{-- Exportaciones (Estilo Compacto) --}}
                <div class="flex items-center rounded-xl bg-gray-100 dark:bg-gray-800 p-1">
                    @if($exportPdf)
                        <a href="{{ $exportPdf }}" target="_blank" title="Exportar PDF"
                            class="p-2 text-gray-500 hover:text-red-600 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all">
                            <i class="fa-solid fa-file-pdf text-lg"></i>
                        </a>
                    @endif
                    @if($exportExcel)
                        <a href="{{ $exportExcel }}" title="Exportar Excel"
                            class="p-2 text-gray-500 hover:text-green-600 hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all">
                            <i class="fa-solid fa-file-excel text-lg"></i>
                        </a>
                    @endif
                </div>

                @if($perPage !== null)
                <select wire:model.live="perPage" class="h-[42px] text-xs font-semibold rounded-xl border-gray-200 bg-white px-3 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 focus:ring-indigo-500/20">
                    <option value="10">10 Filas</option>
                    <option value="25">25 Filas</option>
                    <option value="50">50 Filas</option>
                </select>
                @endif

                @if($filters->isNotEmpty())
                <button 
                    @click="$dispatch('toggle-filtros')" 
                    class="h-[42px] inline-flex items-center px-4 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800/50 transition-all font-bold text-sm"
                >
                    <i class="fa-solid fa-filter mr-2"></i>
                    Filtros
                </button>
                @endif

                @if($createRoute)
                    <x-form.button-primary 
                        tag="a" 
                        href="{{ $createRoute }}" 
                        class="w-full lg:w-auto shadow-sm"
                    >
                    <i class="fa-solid fa-plus mr-1"></i>
                        Nuevo Usuario
                    </x-form.button-primary>
                @endif
            </div>
        </div>
    </div>

    {{-- FILTROS PANEL DESPLEGABLE --}}
    <div 
        x-data="{ show: false }" 
        @toggle-filtros.window="show = !show"
        x-show="show"
        x-cloak
        x-collapse {{-- Requiere el plugin Collapse de Alpine --}}
        class="bg-gray-50/50 dark:bg-white/[0.01] border-b border-gray-100 dark:border-gray-800"
    >
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{ $filters }}
            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="relative">
        {{-- Loading Overlay --}}
        <div wire:loading class="absolute inset-0 z-10 bg-white/50 dark:bg-gray-900/50 backdrop-blur-[1px] flex items-center justify-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
        </div>
        
        <div class="overflow-x-auto">
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
                const modelName = $el.data('model');
                
                // Evitar duplicados
                if ($el.data('select2')) { $el.select2('destroy'); }

                $el.select2({
                    placeholder: $el.data('placeholder') || 'Seleccionar...',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $el.closest('.rounded-2xl') // Mantiene el dropdown dentro del contexto visual
                });

                // Sincronizar valor inicial
                let currentVal = @this.get(modelName);
                if(currentVal) $el.val(currentVal).trigger('change.select2');

                // Escuchar cambios
                $el.on('change', function () {
                    @this.set(modelName, $(this).val());
                });
            });
        };

        initSelect2();

        // Re-inicializar cuando se abren los filtros o Livewire actualiza el DOM
        window.addEventListener('toggle-filtros', () => setTimeout(initSelect2, 100));
        Livewire.hook('morph.updated', () => initSelect2());
    });
</script>
@endpush