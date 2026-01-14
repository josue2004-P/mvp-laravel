@props([
    'search' => null,
    'perPage' => null,
    'exportPdf' => null,
    'exportExcel' => null,
    'createRoute' => null,
    'title' => 'Registros'
])

<div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
    {{-- BARRA SUPERIOR --}}
    <div class="flex flex-col gap-4 px-5 mb-4 lg:flex-row lg:items-center lg:justify-between sm:px-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            {{-- Selector de cantidad --}}
            @if($perPage !== null)
            <div class="flex items-center gap-2">
                <select wire:model.live="perPage" class="h-[42px] text-sm rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
            @endif
            {{-- Botón Toggle Filtros (Solo si hay contenido en el slot de filtros) --}}
            @if($filters->isNotEmpty())
            <button @click="$dispatch('toggle-filtros')" class="inline-flex items-center justify-center px-4 py-2 bg-[#008196] hover:bg-[#006a7c] text-white text-sm font-medium rounded-md transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filtros
            </button>
            @endif

            {{-- Botones de exportación y nuevo --}}
            <div class="flex items-center gap-2">
                @if($exportPdf)
                    <a href="{{ $exportPdf }}"
                        target="_blank"
                        class="flex items-center justify-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 w-full lg:w-auto">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.93a1 1 0 1 0-1.41 1.41l4.93 4.93c.39.39 1.02.39 1.41 0l4.93-4.93a1 1 0 0 0-1.41-1.41L13 11.15Z"/><path d="M9.657 15.828 7.343 13.515A1 1 0 0 0 5.929 14.93l2.314 2.313H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2h-3.243l2.314-2.313a1 1 0 0 0-1.414-1.414l-2.314 2.313a.4.4 0 0 1-.572 0Z"/></svg>
                        Importar PDF
                    </a>
                @endif
                
                 @if($exportExcel)
                    <a href="{{  $exportExcel }}"
                        class="flex items-center justify-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 w-full lg:w-auto">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M13 11.15V4a1 1 0 1 0-2 0v7.15L8.78 8.93a1 1 0 1 0-1.41 1.41l4.93 4.93c.39.39 1.02.39 1.41 0l4.93-4.93a1 1 0 0 0-1.41-1.41L13 11.15Z"/><path d="M9.657 15.828 7.343 13.515A1 1 0 0 0 5.929 14.93l2.314 2.313H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2h-3.243l2.314-2.313a1 1 0 0 0-1.414-1.414l-2.314 2.313a.4.4 0 0 1-.572 0Z"/></svg>
                        Importar Excel
                    </a>
                @endif

                @if($createRoute)
                    <a href="{{ $createRoute  }}"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 w-full lg:w-auto">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                        Nuevo
                    </a>
                @endif
            </div>

            {{-- Buscador --}}
            @if($search !== null)
            <div class="relative flex-grow lg:flex-grow-0">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar..." class="h-[42px] w-full lg:w-[250px] rounded-lg border-gray-300 bg-transparent pl-10 pr-4 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- FILTROS CONTENEDOR --}}
    <div 
        x-data="{ show: false }" 
        @toggle-filtros.window="show = !show; if(show) { setTimeout(() => initSelect2(), 100) }"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="max-w-full mx-5 py-4 my-4 border-gray-200 border-y dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg px-4">
        <div class="grid md:grid-cols-2 gap-4">
            {{ $filters }}
        </div>
    </div>

    {{-- TABLA (CONTENIDO PRINCIPAL) --}}
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>
</div>


@push('scripts')
<script>
    function initGlobalSelect2() {
        $('.select2-dynamic').each(function () {
            const $el = $(this);
            const modelName = $el.data('model');
            const placeholder = $el.data('placeholder') || 'Seleccionar...';

            if ($el.data('select2')) { $el.select2('destroy'); }

            $el.select2({
                placeholder: placeholder,
                allowClear: true,
                width: '100%'
            });

            // --- NUEVO: Sincronizar valor inicial de Livewire a Select2 ---
            // Leemos el valor actual de la propiedad en el componente Livewire
            let valorActual = @this.get(modelName);
            if(valorActual) {
                $el.val(valorActual).trigger('change.select2');
            }
            // -------------------------------------------------------------

            $el.on('change', function () {
                const value = $(this).val();
                @this.set(modelName, value);
            });
        });
    }

    document.addEventListener('livewire:initialized', initGlobalSelect2);
    document.addEventListener('livewire:navigated', initGlobalSelect2);
    
    window.addEventListener('toggle-filtros', () => {
        setTimeout(initGlobalSelect2, 150);
    });
</script>
@endpush