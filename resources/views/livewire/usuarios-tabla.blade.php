<x-form.table-filters 
    title="Listado de Usuarios"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('usuarios.create')"
>
    <x-slot:filters>
        {{-- Aquí irían filtros extra como "Rol" o "Estado" --}}
    </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Usuario</th>
                    <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Email</th>
                    <th class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Rol / Perfiles</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800 bg-transparent">
                @forelse($usuarios as $usuario)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-200 dark:border-indigo-800">
                                    <span class="text-indigo-700 dark:text-indigo-400 font-bold text-sm">
                                        {{ substr($usuario->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $usuario->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ $usuario->id }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $usuario->email }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @forelse($usuario->perfiles as $perfil)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                        {{ $perfil->nombre }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">Sin perfil</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block text-left">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition-all focus:ring-2 focus:ring-indigo-500/20"
                                >
                                    <i class="fa-solid fa-ellipsis-vertical text-lg"></i>
                                </button>

                                <template x-teleport="body">
                                    <div 
                                        x-show="dropdownOpen" 
                                        @click.away="dropdownOpen = false"
                                        x-anchor.bottom-end.offset.8="$refs.button"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        class="z-[100] w-44 rounded-2xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-900 overflow-hidden"
                                    >
                                        <div class="py-1.5 px-2 space-y-0.5">
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors">
                                                <i class="fa-solid fa-pen-to-square mr-3 opacity-70"></i>
                                                Editar Perfil
                                            </a>
                                            <div class="my-1 border-t border-gray-100 dark:border-gray-800"></div>
                                            <button 
                                                wire:click="confirmDelete({{ $usuario->id }})" 
                                                class="flex w-full items-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors"
                                            >
                                                <i class="fa-solid fa-trash-can mr-3 opacity-70"></i>
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
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 rounded-full bg-gray-50 dark:bg-gray-800 mb-4">
                                    <i class="fa-solid fa-user-slash text-4xl text-gray-300 dark:text-gray-600"></i>
                                </div>
                                <h3 class="text-gray-900 dark:text-white font-semibold">No hay usuarios</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Intenta ajustar los términos de búsqueda.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 bg-gray-50/30 dark:bg-transparent border-t border-gray-200 dark:border-gray-800">
        {{ $usuarios->links() }}
    </div>
</x-form.table-filters>