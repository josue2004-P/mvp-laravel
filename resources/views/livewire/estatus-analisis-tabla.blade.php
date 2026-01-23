<x-form.table-filters 
    title="Configuración de Estatus de Análisis"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('estatus-analisis.create')"
>
   {{-- Slot de Filtros Específicos --}}
    <x-slot:filters>
        {{-- Aquí podrías añadir un select para filtrar por Abierto/Cerrado en el futuro --}}
    </x-slot:filters>

    <table class="min-w-full">
        <thead>
            <tr class="border-y border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-white/[0.02]">
                <th scope="col" class="px-4 py-3 text-start text-xs font-bold text-gray-500 uppercase dark:text-gray-400 tracking-wider">Orden</th>
                <th scope="col" class="px-4 py-3 text-start text-xs font-bold text-gray-500 uppercase dark:text-gray-400 tracking-wider">Identificador (Badge)</th>
                <th scope="col" class="px-4 py-3 text-start text-xs font-bold text-gray-500 uppercase dark:text-gray-400 tracking-wider">Descripción</th>
                <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase dark:text-gray-400 tracking-wider">Reglas</th>
                <th scope="col" class="relative px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($estatusAnalisis as $key => $value)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition-colors group">
                    {{-- ID / Orden --}}
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-400">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- Badge Dinámico (Nombre) --}}
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span 
                            class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest shadow-sm border border-black/5"
                            style="color: {{ $value->color_texto }}; background-color: {{ $value->color_fondo }};"
                        >
                            {{ $value->nombre }}
                        </span>
                    </td>

                    {{-- Descripción --}}
                    <td class="px-4 py-3">
                        <div class="text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $value->descripcion }}">
                            {{ $value->descripcion }}
                        </div>
                    </td>

                    {{-- Reglas de Negocio (Iconos rápidos) --}}
                    <td class="px-4 py-3 whitespace-nowrap text-center">
                        <div class="flex justify-center gap-2">
                            @if($value->analisis_abierto)
                                <span class="group/tip relative">
                                    <i class="fa-solid fa-lock-open text-indigo-500 text-xs"></i>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/tip:block bg-gray-900 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap">Abierto</span>
                                </span>
                            @endif
                            @if($value->analisis_cerrado)
                                <span class="group/tip relative">
                                    <i class="fa-solid fa-lock text-red-500 text-xs"></i>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover/tip:block bg-gray-900 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap">Cerrado</span>
                                </span>
                            @endif
                        </div>
                    </td>

                    {{-- Acciones --}}
                    <td class="px-4 py-3 text-center whitespace-nowrap text-sm font-medium">
                        <div x-data="{ dropdownOpen: false }" class="relative inline-block">
                            <button 
                                @click="dropdownOpen = !dropdownOpen" 
                                x-ref="button"
                                type="button" 
                                class="p-2 rounded-xl text-gray-400 hover:bg-white dark:hover:bg-gray-800 hover:text-indigo-600 hover:shadow-sm transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-700"
                            >
                                <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                            </button>

                            <template x-teleport="body">
                                <div 
                                    x-show="dropdownOpen" 
                                    @click.away="dropdownOpen = false"
                                    x-anchor.bottom-end.offset.5="$refs.button"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    class="z-[999] w-52 rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-sm shadow-2xl dark:border-gray-700 dark:bg-gray-900/95"
                                >
                                    <div class="p-2 space-y-1">
                                        <a href="{{ route('estatus-analisis.edit', $value->id) }}" class="flex items-center px-3 py-2.5 text-sm text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 rounded-xl transition-colors">
                                            <i class="fa-solid fa-pen-to-square mr-3 text-indigo-500"></i>
                                            Editar Estatus
                                        </a>
                                        <div class="h-px bg-gray-100 dark:bg-gray-800 my-1"></div>
                                        <button 
                                            wire:click="confirmDelete({{ $value->id }})" 
                                            class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors group/del"
                                        >
                                            <i class="fa-solid fa-trash-can mr-3 text-red-400 group-hover/del:text-red-500 transition-colors"></i>
                                            Eliminar Registro
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </td>
                </tr>
            @empty
                 <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="h-16 w-16 rounded-3xl bg-gray-100 dark:bg-white/[0.02] flex items-center justify-center text-gray-400 mb-4">
                                <i class="fa-solid fa-vial-circle-check text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sin estatus registrados</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando el primer estatus para el flujo de análisis.</p>
                            <a href="{{ route('estatus-analisis.create') }}" class="mt-4 text-indigo-600 font-bold text-sm hover:underline">
                                + Crear nuevo estatus
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación Mejorada --}}
    @if($estatusAnalisis->hasPages())
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-white/[0.01] border-t border-gray-200 dark:border-gray-700">
            {{ $estatusAnalisis->links() }}
        </div>
    @endif
</x-form.table-filters>