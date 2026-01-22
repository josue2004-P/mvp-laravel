<x-form.table-filters 
    title="Listado de Métodos Analíticos"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('tipo_metodo.create')"
>
   <x-slot:filters>
       {{-- Espacio para filtros específicos por categoría técnica --}}
   </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">ID</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Metodología / Técnica</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Descripción del Proceso</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-white dark:bg-transparent">
                @forelse($metodos as $key => $metodo)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-all duration-200">
                        {{-- ID con estilo mono --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400 dark:text-gray-500">
                            <span class="opacity-50">#</span>{{ str_pad($metodo->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Nombre con Icono de Laboratorio --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold text-sm mr-4 border border-teal-100/50 dark:border-teal-500/20 shadow-sm">
                                    <i class="fa-solid fa-flask-vial text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
                                        {{ $metodo->nombre }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold mt-0.5">
                                        Técnica Analítica
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Descripción con truncate --}}
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 max-w-sm truncate italic">
                                {{ $metodo->descripcion ?? 'Sin fundamentación técnica registrada' }}
                            </div>
                        </td>

                        {{-- Botón de Acciones Estilizado --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    type="button" 
                                    class="p-2.5 rounded-xl text-gray-400 hover:text-teal-600 hover:bg-teal-50 dark:hover:bg-teal-500/10 transition-all duration-200 border border-transparent hover:border-teal-100 dark:hover:border-teal-500/20"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>

                                <template x-teleport="body">
                                    <div 
                                        x-show="dropdownOpen" 
                                        @click.away="dropdownOpen = false"
                                        x-anchor.bottom-end.offset.8="$refs.button"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        class="z-[999] w-52 rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-sm shadow-2xl dark:border-gray-700 dark:bg-gray-900/95 p-1.5"
                                    >
                                        <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 mb-1.5">
                                            Laboratorio
                                        </div>
                                        <a href="{{ route('tipo_metodo.edit', $metodo->id) }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-500/10 hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition-colors">
                                            <i class="fa-solid fa-microscope mr-3 text-gray-400 group-hover:text-teal-500"></i>
                                            Detalles Técnicos
                                        </a>
                                        <button wire:click="confirmDelete({{ $metodo->id }})" class="flex w-full items-center px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors mt-0.5">
                                            <i class="fa-solid fa-trash-can mr-3 text-red-400"></i>
                                            Eliminar Método
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 rounded-full bg-teal-50 dark:bg-white/5 mb-4">
                                    <i class="fa-solid fa-vial-virus text-3xl text-teal-200 dark:text-teal-900"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-bold">Sin metodologías analíticas</p>
                                <p class="text-xs text-gray-400 mt-1">Registra los métodos (Colorimetría, Inmunología, etc.) para los análisis.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if($metodos->hasPages())
        <div class="px-6 py-4 bg-gray-50/30 dark:bg-white/[0.01] border-t border-gray-200 dark:border-gray-700">
            {{ $metodos->links() }}
        </div>
    @endif
</x-form.table-filters>