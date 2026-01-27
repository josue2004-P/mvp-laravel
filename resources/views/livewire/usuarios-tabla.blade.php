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
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">
                        Identidad del Usuario
                    </th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">
                        Correo Electrónico
                    </th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">
                        Permisos / Roles
                    </th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider dark:text-slate-400">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-transparent">
                @forelse($usuarios as $usuario)
                    <tr class="group hover:bg-emerald-50/30 dark:hover:bg-emerald-500/5 transition-all duration-200">
                        {{-- Identidad --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="relative inline-flex items-center justify-center flex-shrink-0 h-11 w-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-md shadow-emerald-200 dark:shadow-none transition-transform group-hover:scale-105">
                                    <span class="text-white font-extrabold text-sm tracking-tighter">
                                        {{ strtoupper(substr(trim($usuario->name), 0, 1)) }}{{ strlen($usuario->name) > 1 ? strtoupper(substr(trim($usuario->name), 1, 1)) : '' }}
                                    </span>
                                    <span class="absolute -bottom-1 -right-1 h-3.5 w-3.5 rounded-full border-2 border-white dark:border-slate-900 shadow-sm {{ $usuario->is_activo ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        {{ $usuario->name }}
                                    </div>
                                    <div class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest">UID: #{{ str_pad($usuario->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                <i class="fa-regular fa-envelope mr-2 opacity-50 text-xs"></i>
                                <span class="font-medium lowercase tracking-tight">{{ $usuario->email }}</span>
                            </div>
                        </td>

                        {{-- Roles / Perfiles --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($usuario->perfiles as $perfil)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700 dark:bg-white/5 dark:text-slate-400 border border-slate-200 dark:border-white/10 group-hover:border-emerald-200 dark:group-hover:border-emerald-500/30 transition-all">
                                        <i class="fa-solid fa-shield-halved mr-1.5 text-[8px] opacity-70"></i>
                                        {{ $perfil->nombre }}
                                    </span>
                                @empty
                                    <span class="text-[11px] text-slate-400 italic font-medium">Sin accesos configurados</span>
                                @endforelse
                            </div>
                        </td>

                        {{-- Acciones --}}
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
                                            Control de Acceso
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-user-gear mr-3 text-slate-400 group-hover/item:text-emerald-500 transition-colors"></i>
                                                Editar Perfil
                                            </a>
                                            <div class="my-1 border-t border-slate-50 dark:border-slate-800"></div>
                                            @if($usuario->is_activo)
                                                <button 
                                                    wire:click="confirmDelete({{ $usuario->id }})" 
                                                    class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-colors group/del"
                                                >
                                                    <i class="fa-solid fa-user-xmark mr-3 text-rose-400 group-hover/del:text-rose-500 transition-colors"></i>
                                                    Desactivar Cuenta
                                                </button>
                                            @else
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
                                <div class="h-20 w-20 bg-slate-50 dark:bg-white/[0.02] rounded-full flex items-center justify-center mb-4 border border-slate-100 dark:border-white/5">
                                    <i class="fa-solid fa-users-slash text-3xl text-slate-300 dark:text-slate-700"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Base de datos vacía</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xs mx-auto mt-1">No se encontraron usuarios que coincidan con los criterios de búsqueda.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-form.table-filters>