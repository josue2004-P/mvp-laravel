<x-form.table-filters 
    title="Directorio de Personal"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('usuarios.create')"
>
    <x-slot:filters>
    </x-slot:filters>

    <div class="overflow-hidden border border-slate-200 dark:border-slate-800 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-[#001f3f]/20">
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-4 py-3 text-center text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400 w-12">#</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400">Usuario</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400">Nombre(s)</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400">Apellido Paterno</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400">Apellido Materno</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400">Correo Electrónico</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-center text-[10px] font-black text-slate-500 uppercase tracking-widest dark:text-slate-400 w-32">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-transparent">
                @forelse($usuarios as $usuario)
                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors duration-150">
                        <td class="border border-slate-200 dark:border-slate-800 px-4 py-4 text-center text-[10px] font-mono font-bold text-slate-400">
                            {{ $loop->iteration + ($usuarios->currentPage() - 1) * $usuarios->perPage() }}
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-2 w-2 rounded-full {{ $usuario->is_activo ? 'bg-blue-500 shadow-[0_0_5px_rgba(59,130,246,0.8)]' : 'bg-rose-500' }}"></div>
                                <span class="text-[11px] font-mono font-black text-[#001f3f] dark:text-blue-400 uppercase tracking-tighter">
                                    {{ $usuario->usuario }}
                                </span>
                            </div>
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 whitespace-nowrap text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-tight">
                            {{ $usuario->name }}
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 whitespace-nowrap text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-tight">
                            {{ $usuario->apellido_paterno }}
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 whitespace-nowrap text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-tight">
                            {{ $usuario->apellido_materno ?? '-' }}
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 whitespace-nowrap">
                            <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400 lowercase italic">
                                {{ $usuario->email }}
                            </span>
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                                    class="h-7 w-7 flex items-center justify-center rounded border border-slate-300 bg-white text-slate-600 hover:bg-[#001f3f] hover:text-white dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-white dark:hover:text-[#001f3f] transition-all shadow-sm"
                                    title="Editar Expediente">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                </a>
                                @if($usuario->is_activo)
                                    <button wire:click="confirmDelete({{ $usuario->id }})" 
                                        class="h-7 w-7 flex items-center justify-center rounded border border-rose-100 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-950/20 dark:border-rose-900/40 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white transition-all shadow-sm"
                                        title="Desactivar Usuario">
                                        <i class="fa-solid fa-user-xmark text-[10px]"></i>
                                    </button>
                                @else
                                    <button wire:click="confirmActive({{ $usuario->id }})" 
                                        class="h-7 w-7 flex items-center justify-center rounded border border-blue-100 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-950/20 dark:border-blue-900/40 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white transition-all shadow-sm"
                                        title="Activar Usuario">
                                        <i class="fa-solid fa-user-check text-[10px]"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-slate-200 dark:border-slate-800 px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 bg-slate-50 dark:bg-[#001f3f]/10 rounded-lg flex items-center justify-center mb-4 border border-slate-100 dark:border-[#001f3f]/20">
                                    <i class="fa-solid fa-users-slash text-2xl text-slate-200 dark:text-slate-800"></i>
                                </div>
                                <h3 class="text-[10px] font-black text-[#001f3f] dark:text-white uppercase tracking-[0.3em]">Registro de Personal Vacío</h3>
                                <p class="text-[9px] text-slate-400 uppercase font-bold tracking-widest mt-2">No se han detectado nodos de usuario en la base de datos.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($usuarios->hasPages())
        <div class="mt-4 px-2">
            {{ $usuarios->links() }}
        </div>
    @endif
</x-form.table-filters>