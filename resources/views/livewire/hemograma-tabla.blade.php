<x-form.table-filters 
    title="Parámetros de Hemograma"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('hemograma_completo.create')"
>
   {{-- Slot de Filtros Específicos --}}
    <x-slot:filters>
        <div wire:ignore class=" sm:col-span-6 lg:col-span-5"> 
            <x-form.input-select-filter
                id="categoriaHemogramaCompletoSelect" 
                name="categoriaHemogramaCompleto" 
                dataModel="categoriaHemogramaCompletoId" 
                label="Filtrar por Categoría" >
                <option value="">Todas las categorías</option>
                @foreach($categoriasHemogramaCompleto as $chcm)
                    <option value="{{ $chcm->id }}">
                        {{ $chcm->nombre }}
                    </option>
                @endforeach
            </x-form.input-filter >
        </div>
    </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">ID</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Parámetro Analítico</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Categoría</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Unidad</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Rango de Referencia</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-white dark:bg-transparent">
                @forelse($hemogramas as $hemograma)
                    <tr class="group hover:bg-red-50/30 dark:hover:bg-red-900/10 transition-all duration-200">
                        {{-- ID --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400">
                            #{{ str_pad($hemograma->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Nombre --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 font-bold text-xs mr-3 border border-red-200 dark:border-red-800/50">
                                    <i class="fa-solid fa-droplet"></i>
                                </div>
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-red-600 transition-colors">
                                    {{ $hemograma->nombre }}
                                </div>
                            </div>
                        </td>

                        {{-- Categoría con Badge --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 border border-blue-100 dark:border-blue-800">
                                <i class="fa-solid fa-tag mr-1.5 opacity-50"></i>
                                {{ $hemograma->categoria->nombre }}
                            </span>
                        </td>

                        {{-- Unidad con estilo Mono --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs font-mono font-bold px-2 py-1 rounded bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-white/10">
                                {{ $hemograma->unidad->nombre }}
                            </span>
                        </td>

                        {{-- Referencia --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400 italic font-mono">
                                {{ $hemograma->referencia ?? 'Pendiente de definir' }}
                            </div>
                        </td>

                        {{-- Acciones Dropdown --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block text-left">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    type="button" 
                                    class="p-2 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                                >
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>

                                <template x-teleport="body">
                                    <div 
                                        x-show="dropdownOpen" 
                                        @click.away="dropdownOpen = false"
                                        x-anchor.bottom-end.offset.5="$refs.button"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        class="z-[999] w-52 rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-sm shadow-2xl dark:border-gray-700 dark:bg-gray-900/95 p-1.5"
                                    >
                                        <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-800 mb-1.5">
                                            Hematología
                                        </div>
                                        <a href="{{ route('hemograma_completo.edit', $hemograma->id) }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 rounded-xl transition-colors">
                                            <i class="fa-solid fa-pen-to-square mr-3 text-gray-400 group-hover:text-red-500"></i>
                                            Editar Parámetro
                                        </a>
                                        <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>
                                        <button wire:click="confirmDelete({{ $hemograma->id }})" class="flex w-full items-center px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                            <i class="fa-solid fa-trash-can mr-3 text-red-400"></i>
                                            Eliminar Registro
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-900/10 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-microscope text-2xl text-red-300 dark:text-red-700"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-bold italic text-lg">Sin parámetros configurados</p>
                                <p class="text-xs text-gray-400 mt-1 max-w-xs mx-auto">Comienza agregando los elementos de la biometría hemática (Hemoglobina, Hematocrito, etc.)</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if($hemogramas->hasPages())
        <div class="px-6 py-4 bg-gray-50/30 dark:bg-white/[0.01] border-t border-gray-200 dark:border-gray-700">
            {{ $hemogramas->links() }}
        </div>
    @endif
</x-form.table-filters>