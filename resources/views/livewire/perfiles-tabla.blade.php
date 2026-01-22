<x-form.table-filters 
    title="Gestión de Perfiles"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('perfiles.create')"
>
   {{-- Slot de Filtros Específicos --}}
    <x-slot:filters>
    </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">ID</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nombre del Perfil</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Descripción</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-white dark:bg-transparent">
                @forelse($perfiles as $perfil)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.01] transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                #{{ $perfil->id }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center mr-3">
                                    <i class="fa-solid fa-id-badge text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 lowercase">
                                    {{ $perfil->nombre }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                {{ $perfil->descripcion ?: 'Sin descripción adicional' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    class="p-2 rounded-xl text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all"
                                >
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>

                                <template x-teleport="body">
                                    <div 
                                        x-show="dropdownOpen" 
                                        @click.away="dropdownOpen = false"
                                        x-anchor.bottom-end.offset.8="$refs.button"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        class="z-[9999] w-48 rounded-2xl border border-gray-200 bg-white p-1.5 shadow-xl dark:border-gray-700 dark:bg-gray-900"
                                    >
                                        <a href="{{ route('perfiles.edit', $perfil->id) }}" class="group flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl transition-colors">
                                            <i class="fa-solid fa-user-gear mr-3 text-gray-400 group-hover:text-indigo-600"></i>
                                            Gestionar Perfil
                                        </a>
                                        <div class="my-1 border-t border-gray-100 dark:border-gray-800"></div>
                                        <button 
                                            wire:click="confirmDelete({{ $perfil->id }})" 
                                            class="group flex w-full items-center px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors"
                                        >
                                            <i class="fa-solid fa-trash-can mr-3 text-red-400 group-hover:text-red-600"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-white/[0.02] mb-4">
                                <i class="fa-solid fa-users-slash text-2xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No hay perfiles registrados.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50/30 dark:bg-transparent border-t border-gray-100 dark:border-gray-800">
        {{ $perfiles->links() }}
    </div>
</x-form.table-filters>