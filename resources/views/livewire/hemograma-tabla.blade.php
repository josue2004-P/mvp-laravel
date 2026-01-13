<div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
    
    {{-- FILTRO BOTONES --}}
    <div class="flex flex-col gap-4 px-5 mb-4 lg:flex-row lg:items-center lg:justify-between sm:px-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 text-center lg:text-left">Analisis</h3>
        </div>

        <div class="flex flex-col gap-3 sm:grid sm:grid-cols-2 lg:flex lg:flex-row lg:items-center w-full lg:w-auto">
            
            <button 
                @click="$dispatch('toggle-filtros')" 
                class="inline-flex items-center justify-center px-4 py-2 bg-[#008196] hover:bg-[#006a7c] text-white text-sm font-medium rounded-md shadow-sm transition-all w-full lg:w-fit"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span x-text="openFiltros ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
            </button>

            <form wire:submit.prevent="render" class="sm:col-span-2 lg:w-auto w-full"> 
                <div class="relative w-full">
                    <button type="submit" class="absolute -translate-y-1/2 left-4 top-1/2">
                        <svg class="fill-gray-500 dark:fill-gray-400" width="18" height="18" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" clip-rule="evenodd"/></svg>
                    </button>
                    <input type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Buscar..." 
                        class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 lg:w-[250px] xl:w-[300px]"/>
                </div>
            </form>
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
            <div wire:ignore class="w-full"> 
                <x-form.input-select-filter
                    id="categoriaHemogramaCompletoSelect" 
                    name="categoriaHemogramaCompleto" 
                    dataModel="categoriaHemogramaCompletoId" 
                    label="Tipo de Categoria Hemograma " >
                    <option value="">Selecciona una Categoria de Hemograma</option>
                    @foreach($categoriasHemogramaCompleto as $chcm)
                        <option value="{{ $chcm->id }}">
                            {{ $chcm->nombre }}
                        </option>
                    @endforeach
                </x-form.input-filter >
            </div>
        </div>
    </div>
    
    {{-- TABLA --}}
    <div class="overflow-x-auto  sm:pb-0"> 
        <div class="max-w-full px-4 sm:px-5">
            <div class="overflow-x-auto custom-scrollbar"> 
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="border-y border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-white/[0.02]">
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Id</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Nombre</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Categoria</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Unidad</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400 ">Referencia</th>
                            <th scope="col" class="relative px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($hemogramas as $hemograma)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                            <td class="px-4 py-1 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                #{{ $hemograma['id']  }}
                            </td>
                            <td class="px-4 py-1 whitespace-nowrap">
                                <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $hemograma['nombre']  }}</div>
                            </td>
                            <td class="px-4 py-1 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $hemograma->categoria->nombre  }}
                                </span>
                            </td>
                              <td class="px-4 py-1 whitespace-nowrap">
                                <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $hemograma->unidad->nombre  }}</div>
                            </td>
                              <td class="px-4 py-1 whitespace-nowrap">
                                <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $hemograma->referencia }}</div>
                            </td>
                            <td class="px-4 py-1 text-center whitespace-nowrap text-sm font-medium">
                                <div x-data="{ dropdownOpen: false }" class="inline-block">
                                    <button 
                                        @click="dropdownOpen = !dropdownOpen" 
                                        x-ref="button" {{-- Referencia para posicionar el menú --}}
                                        type="button" 
                                        class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all"
                                    >
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 10.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM12 4.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM12 16.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                        </svg>
                                    </button>

                                    <template x-teleport="body">
                                        <div 
                                            x-show="dropdownOpen" 
                                            @click.away="dropdownOpen = false"
                                            x-anchor.bottom-end.offset.5="$refs.button" {{-- Requiere plugin Anchor de Alpine --}}
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            class="z-[999] w-48 rounded-xl border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900"
                                        >
                                            <div class="p-1">
                                                <a href="{{ route('hemograma_completo.edit',$hemograma['id'])  }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    Ver detalles
                                                </a>
                                                <button wire:click="confirmDelete({{ $hemograma->id }})" class="flex w-full items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg text-left">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No se encontraron resultados para la búsqueda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-white/[0.05]">
            {{ $hemogramas->links() }}
        </div>
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