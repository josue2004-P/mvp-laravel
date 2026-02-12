<x-form.table-filters 
    title="Listado de Perfiles"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('perfiles.create')"
>
    <x-slot:filters>
    </x-slot:filters>

    <div class="overflow-hidden border border-slate-200 dark:border-slate-800 rounded-lg shadow-sm">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-[#001f3f]/20">
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-4 py-3 text-center text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] dark:text-slate-400 w-16">#</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] dark:text-slate-400">Nombre</th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-start text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] dark:text-slate-400">Descripción </th>
                    <th scope="col" class="border border-slate-200 dark:border-slate-800 px-6 py-3 text-center text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] dark:text-slate-400 w-40">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-transparent">
                @forelse($perfiles as $perfil)
                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-colors duration-150">
                        {{-- ID con formato industrial --}}
                        <td class="border border-slate-200 dark:border-slate-800 px-4 py-4 text-center whitespace-nowrap">
                            <span class="font-mono text-[11px] font-black text-slate-400 dark:text-slate-600 tracking-tighter">
                                {{ $loop->iteration + ($perfiles->currentPage() - 1) * $perfiles->perPage() }}

                            </span>
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded bg-[#001f3f] flex items-center justify-center text-white border border-[#001f3f] shadow-sm">
                                    <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                </div>
                                <span class="text-[11px] font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                    {{ $perfil->nombre }}
                                </span>
                            </div>
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4">
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest leading-relaxed">
                                {{ $perfil->descripcion ?: 'SIN ESPECIFICACIÓN TÉCNICA' }}
                            </span>
                        </td>
                        <td class="border border-slate-200 dark:border-slate-800 px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('perfiles.edit', $perfil->id) }}" 
                                    class="h-7 px-3 flex items-center justify-center rounded border border-slate-300 bg-white text-[9px] font-black uppercase tracking-widest text-slate-600 hover:bg-[#001f3f] hover:text-white dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-white dark:hover:text-[#001f3f] transition-all shadow-sm"
                                    title="Configurar Matriz de Permisos">
                                    Configurar
                                </a>
                                <button wire:click="confirmDelete({{ $perfil->id }})" 
                                    class="h-7 w-7 flex items-center justify-center rounded border border-rose-100 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-950/20 dark:border-rose-900/40 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white transition-all shadow-sm"
                                    title="Eliminar Perfil">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-slate-200 dark:border-slate-800 px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-16 w-16 bg-slate-50 dark:bg-[#001f3f]/10 rounded-lg flex items-center justify-center mb-4 border border-slate-100 dark:border-[#001f3f]/20">
                                    <i class="fa-solid fa-folder-open text-2xl text-slate-200 dark:text-slate-800"></i>
                                </div>
                                <h3 class="text-[10px] font-black text-[#001f3f] dark:text-white uppercase tracking-[0.3em]">Jerarquía sin Datos</h3>
                                <p class="text-[9px] text-slate-400 uppercase font-bold tracking-widest mt-2">No se han definido perfiles de acceso en el sistema.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($perfiles->hasPages())
        <div class="mt-4 px-2">
            {{ $perfiles->links() }}
        </div>
    @endif
</x-form.table-filters>