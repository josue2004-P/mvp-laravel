<x-form.table-filters 
    title="Gestión de Usuarios"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('usuarios.create')"
>
    <x-slot:filters>
        {{-- Filtro por Rol/Perfil si fuera necesario --}}
    </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Identidad del Usuario
                    </th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Correo Electrónico
                    </th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Permisos / Roles
                    </th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-transparent">
                @forelse($usuarios as $usuario)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-all duration-200">
                        {{-- Identidad --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="relative inline-flex items-center justify-center flex-shrink-0 h-11 w-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-md shadow-indigo-200 dark:shadow-none transition-transform group-hover:scale-105">
                                    <span class="text-white font-extrabold text-sm tracking-tighter">
                                        {{ strtoupper(substr(trim($usuario->name), 0, 1)) }}{{ strlen($usuario->name) > 1 ? strtoupper(substr(trim($usuario->name), 1, 1)) : '' }}
                                    </span>
                                    <span class="absolute -bottom-1 -right-1 h-3.5 w-3.5 rounded-full border-2 border-white dark:border-gray-900 shadow-sm {{ $usuario->is_activo ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $usuario->name }}
                                    </div>
                                    <div class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">UID: #{{ str_pad($usuario->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Email con icono sutil --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <i class="fa-regular fa-envelope mr-2 opacity-50 text-xs"></i>
                                <span class="font-medium lowercase tracking-tight">{{ $usuario->email }}</span>
                            </div>
                        </td>

                        {{-- Roles / Perfiles --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($usuario->perfiles as $perfil)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700 dark:bg-white/5 dark:text-slate-400 border border-slate-200 dark:border-white/10 group-hover:border-indigo-200 dark:group-hover:border-indigo-500/30 transition-all">
                                        <i class="fa-solid fa-shield-halved mr-1.5 text-[8px] opacity-70"></i>
                                        {{ $perfil->nombre }}
                                    </span>
                                @empty
                                    <span class="text-[11px] text-gray-400 italic">Sin accesos configurados</span>
                                @endforelse
                            </div>
                        </td>

                        {{-- Acciones Dropdown Premium --}}
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div x-data="{ dropdownOpen: false }" class="relative inline-block text-left">
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    x-ref="button"
                                    class="p-2.5 rounded-xl text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all border border-transparent hover:border-indigo-100 dark:hover:border-indigo-500/20 shadow-sm"
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
                                            Control de Acceso
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-user-gear mr-3 text-gray-400 group-hover/item:text-indigo-500 transition-colors"></i>
                                                Editar Perfil
                                            </a>
                                            <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>
                                            @if($usuario->is_activo)
                                                {{-- Botón para DESACTIVAR --}}
                                                <button 
                                                    wire:click="confirmDelete({{ $usuario->id }})" 
                                                    class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors group/del"
                                                >
                                                    <i class="fa-solid fa-user-xmark mr-3 text-red-400 group-hover/del:text-red-500 transition-colors"></i>
                                                    Desactivar Cuenta
                                                </button>
                                            @else
                                                {{-- Botón para ACTIVAR --}}
                                                <button 
                                                    wire:click="confirmActive({{ $usuario->id }})" 
                                                    class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-xl transition-colors group/act"
                                                >
                                                    <i class="fa-solid fa-user-check mr-3 text-emerald-400 group-hover/act:text-emerald-500 transition-colors"></i>
                                                    Activar Cuenta
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-gray-50 dark:bg-white/[0.02] rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-white/5">
                                    <i class="fa-solid fa-users-slash text-3xl text-gray-300 dark:text-gray-700"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">Base de datos vacía</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto mt-1">No se encontraron usuarios que coincidan con los criterios de búsqueda actuales.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer de Paginación --}}
    @if($usuarios->hasPages())
        <div class="px-6 py-5 bg-gray-50/30 dark:bg-transparent border-t border-gray-200 dark:border-gray-800">
            {{ $usuarios->links() }}
        </div>
    @endif
</x-form.table-filters>