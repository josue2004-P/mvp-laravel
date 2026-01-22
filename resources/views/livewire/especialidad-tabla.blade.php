<x-form.table-filters 
    title="Listado de Especialidades"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('especialidades.create')"
>
   <x-slot:filters>
       {{-- Filtros adicionales si se requieren --}}
   </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Especialidad Médica
                    </th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Descripción / Alcance
                    </th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-white dark:bg-transparent">
                @forelse($especialidades as $especialidad)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-all duration-200">
                        {{-- ID con estilo mono e índigo --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-semibold text-indigo-600 dark:text-indigo-400">
                            #{{ str_pad($especialidad->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Nombre con Icono --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 dark:text-blue-400 mr-3 border border-blue-100 dark:border-blue-800/50">
                                    <i class="fa-solid fa-microscope text-xs"></i>
                                </div>
                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $especialidad->nombre }}
                                </div>
                            </div>
                        </td>

                        {{-- Descripción con truncate controlado --}}
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs xl:max-w-md truncate italic">
                                {{ $especialidad->descripcion ?? 'Sin descripción detallada' }}
                            </div>
                        </td>

                        {{-- Dropdown con Estilo Mejorado --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    type="button" 
                                    class="p-2.5 rounded-xl text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all border border-transparent hover:border-indigo-100 dark:hover:border-indigo-500/20"
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
                                        class="z-[999] w-48 rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-md shadow-2xl dark:border-gray-700 dark:bg-gray-900/95 p-1.5"
                                    >
                                        <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 mb-1.5">
                                            Configuración
                                        </div>
                                        
                                        <a href="{{ route('especialidades.edit', $especialidad->id) }}" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors">
                                            <i class="fa-solid fa-pen-to-square mr-3 text-gray-400 group-hover:text-indigo-500"></i>
                                            Editar Datos
                                        </a>

                                        <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>

                                        <button wire:click="confirmDelete({{ $especialidad->id }})" class="flex w-full items-center px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors">
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
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-folder-open text-2xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-bold">No hay especialidades registradas</p>
                                <p class="text-xs text-gray-400 mt-1">Comienza agregando una especialidad médica al catálogo.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación Optimizada --}}
    @if($especialidades->hasPages())
        <div class="px-6 py-4 bg-gray-50/30 dark:bg-white/[0.01] border-t border-gray-200 dark:border-gray-700">
            {{ $especialidades->links() }}
        </div>
    @endif
</x-form.table-filters>