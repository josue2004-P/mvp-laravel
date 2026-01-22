<x-form.table-filters 
    title="Diccionario de Seguridad"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('permisos.create')"
>
   <x-slot:filters>
       {{-- Espacio para filtros por prefijo de módulo si el catálogo crece --}}
   </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Identificador</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Alcance / Descripción</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-transparent">
                @forelse($permisos as $key => $permiso)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-all duration-200">
                        {{-- Nombre / Clave con estilo de Código --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 mr-4 border border-zinc-200 dark:border-zinc-700 group-hover:bg-zinc-900 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-code text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-mono font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ $permiso->nombre }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mt-0.5">
                                        Llave de Sistema
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Descripción --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 dark:text-gray-400 italic">
                                {{ $permiso->descripcion ?: 'Sin descripción técnica' }}
                            </div>
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
                                            Configuración de Núcleo
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('permisos.edit', $permiso->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-key-skeleton mr-3 text-gray-400 group-hover/item:text-indigo-500 transition-colors"></i>
                                                Editar Llave
                                            </a>
                                            <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>
                                            <button 
                                                wire:click="confirmDelete({{ $permiso->id }})" 
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
                        <td colspan="3" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-zinc-50 dark:bg-white/[0.02] rounded-full flex items-center justify-center mb-4 border border-zinc-100 dark:border-white/5 shadow-inner">
                                    <i class="fa-solid fa-key text-3xl text-zinc-200 dark:text-zinc-800"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white uppercase tracking-tight">Diccionario Vacío</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto mt-1 italic">
                                    No hay llaves de seguridad registradas en el sistema.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación Premium --}}
    @if($permisos->hasPages())
        <div class="px-6 py-5 bg-gray-50/30 dark:bg-transparent border-t border-gray-200 dark:border-gray-800">
            {{ $permisos->links() }}
        </div>
    @endif
</x-form.table-filters>