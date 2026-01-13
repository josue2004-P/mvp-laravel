<x-form.table-filters 
    title="Listado de Clientes"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('clientes.create')"
    {{-- :exportPdf="route('analisis-general.pdf', ['search' => $search, 'perPage'  => $perPage])" --}}
    {{-- :exportExcel="route('analisis.export', ['search' => $search, 'perPage'  => $perPage])" --}}
>
   {{-- Slot de Filtros Específicos --}}
    <x-slot:filters>
    </x-slot:filters>

    {{-- El Slot por defecto es la tabla --}}
    <table class="min-w-full">
        <thead>
            <tr class="border-y border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-white/[0.02]">
                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Id</th>
                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Nombre</th>
                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Sexo</th>
                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold text-gray-500 uppercase dark:text-gray-400 hidden md:table-cell"">Edad</th>
                <th scope="col" class="relative px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($clientes as $key  => $cliente)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                    <td class="px-4 py-1 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        #{{ $key + 1 }}
                    </td>
                    <td class="px-4 py-1 whitespace-nowrap">
                        <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{  $cliente['nombre']  }}</div>
                    </td>
                    <td class="px-4 py-1 whitespace-nowrap">
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{$cliente['sexo']  }}</div>
                    </td>
                    <td class="px-4 py-1 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden md:table-cell">
                        {{$cliente['edad'] }}
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
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Ver detalles
                                        </a>
                                        <button wire:click="confirmDelete({{ $cliente->id }})" class="flex w-full items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg text-left">
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

    {{-- Paginación al final --}}
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $clientes->links() }}
    </div>
</x-form.table-filters>
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