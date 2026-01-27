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
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">Identificador</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">Alcance / Descripción</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-transparent">
                @forelse($permisos as $key => $permiso)
                    <tr class="group hover:bg-emerald-50/30 dark:hover:bg-emerald-500/5 transition-all duration-200">
                        {{-- Nombre / Clave con estilo de Código --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 mr-4 border border-slate-200 dark:border-slate-700 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-500 transition-all">
                                    <i class="fa-solid fa-code text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $permiso->nombre }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-0.5">
                                        Llave de Sistema
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Descripción --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-600 dark:text-slate-400 italic font-medium">
                                {{ $permiso->descripcion ?: 'Sin descripción técnica' }}
                            </div>
                        </td>

                        {{-- Acciones Dropdown Premium --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block text-left">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    class="p-2.5 rounded-xl text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-all border border-transparent hover:border-emerald-100 dark:hover:border-emerald-500/20 shadow-sm"
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
                                        class="z-[100] w-52 rounded-2xl border border-slate-200 bg-white/95 backdrop-blur-md shadow-2xl dark:border-slate-700 dark:bg-slate-900/95 p-1.5"
                                    >
                                        <div class="px-3 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 mb-1.5">
                                            Configuración de Núcleo
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('permisos.edit', $permiso->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-key-skeleton mr-3 text-slate-400 group-hover/item:text-emerald-500 transition-colors"></i>
                                                Editar Llave
                                            </a>
                                            <div class="my-1 border-t border-slate-50 dark:border-slate-800"></div>
                                            <button 
                                                wire:click="confirmDelete({{ $permiso->id }})" 
                                                class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-colors group/del"
                                            >
                                                <i class="fa-solid fa-trash-can mr-3 text-rose-400 group-hover/del:text-rose-500 transition-colors"></i>
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
                                <div class="h-20 w-20 bg-slate-50 dark:bg-white/[0.02] rounded-full flex items-center justify-center mb-4 border border-slate-100 dark:border-white/5 shadow-inner">
                                    <i class="fa-solid fa-key text-3xl text-slate-200 dark:text-slate-800"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white uppercase tracking-tight">Diccionario Vacío</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xs mx-auto mt-1 italic font-medium">
                                    No hay llaves de seguridad registradas en el sistema.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación Premium Emerald --}}
    @if($permisos->hasPages())
        <div class="px-6 py-5 bg-slate-50/30 dark:bg-transparent border-t border-slate-200 dark:border-slate-800">
            {{ $permisos->links() }}
        </div>
    @endif
</x-form.table-filters>