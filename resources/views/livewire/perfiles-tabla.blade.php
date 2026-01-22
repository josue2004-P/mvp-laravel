<x-form.table-filters 
    title="Jerarquía de Accesos"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('perfiles.create')"
>
    <x-slot:filters>
        {{-- Slot para filtros rápidos si el catálogo crece --}}
    </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">ID</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Perfil del Sistema</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Alcance / Descripción</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Usuarios</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-transparent">
                @forelse($perfiles as $perfil)
                    <tr class="group hover:bg-slate-50/80 dark:hover:bg-indigo-500/5 transition-all duration-200">
                        {{-- ID Mono --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400 dark:text-gray-500">
                            <span class="opacity-50">#</span>{{ str_pad($perfil->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Nombre del Perfil --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-2xl bg-slate-100 dark:bg-white/[0.03] flex items-center justify-center mr-4 border border-slate-200 dark:border-white/10 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                    <i class="fa-solid fa-shield-halved text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 dark:text-white lowercase tracking-tight group-hover:text-indigo-600 transition-colors">
                                        {{ $perfil->nombre }}
                                    </div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                                        Rol de Seguridad
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Descripción con tooltip sutil --}}
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate italic">
                                {{ $perfil->descripcion ?: 'Sin descripción funcional definida' }}
                            </div>
                        </td>

                        {{-- Contador de Usuarios (Si usas withCount) --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 dark:bg-white/5 dark:text-slate-400 border border-slate-200 dark:border-white/10">
                                <i class="fa-solid fa-users text-[10px] mr-1.5 opacity-50"></i>
                                {{ $perfil->usuarios_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Acciones Dropdown Premium --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block text-left">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    class="p-2.5 rounded-xl text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all border border-transparent hover:border-indigo-100 dark:hover:border-indigo-500/20"
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
                                        class="z-[100] w-52 rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-md shadow-2xl dark:border-gray-700 dark:bg-gray-900/95 p-1.5"
                                    >
                                        <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-800 mb-1.5">
                                            Infraestructura
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('perfiles.edit', $perfil->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-gears mr-3 text-gray-400 group-hover/item:text-indigo-500 transition-colors"></i>
                                                Configurar Matriz
                                            </a>
                                            <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>
                                            <button 
                                                wire:click="confirmDelete({{ $perfil->id }})" 
                                                class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors group/del"
                                            >
                                                <i class="fa-solid fa-trash-can mr-3 text-red-400 group-hover/del:text-red-500 transition-colors"></i>
                                                Eliminar Perfil
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-slate-50 dark:bg-white/[0.02] rounded-full flex items-center justify-center mb-4 border border-slate-100 dark:border-white/5">
                                    <i class="fa-solid fa-shield-slash text-3xl text-slate-200 dark:text-slate-800"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white uppercase tracking-tight">Sin Perfiles de Acceso</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto mt-1 italic">
                                    No se han definido roles de seguridad en la base de datos.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($perfiles->hasPages())
        <div class="px-6 py-5 bg-gray-50/30 dark:bg-transparent border-t border-gray-200 dark:border-gray-800">
            {{ $perfiles->links() }}
        </div>
    @endif
</x-form.table-filters>