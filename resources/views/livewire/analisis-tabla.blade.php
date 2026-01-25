<x-form.table-filters 
    title="Listado de Análisis Clínicos"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('analisis.create')"
    :exportPdf="route('analisis-general.pdf', ['search' => $search, 'perPage'  => $perPage, 'doctorId' => $doctorId, 'tipoAnalisisId' => $tipoAnalisisId])"
    :exportExcel="route('analisis.export', ['search' => $search, 'perPage'  => $perPage,'doctorId' => $doctorId, 'tipoAnalisisId' => $tipoAnalisisId])"
>
    {{-- Slot de Filtros Específicos --}}
    <x-slot:filters>
        {{-- Filtro Tipo de Análisis (Ocupa 4/12 - 33%) --}}
        <div wire:ignore class="sm:col-span-6 lg:col-span-4"> 
            <x-form.input-select-filter
                id="tipoAnalisisSelect" 
                name="tipoAnalisis" 
                dataModel="tipoAnalisisId" 
                label="Tipo de Análisis"
                class="!bg-white dark:!bg-gray-800/50 border-gray-200 dark:border-gray-700 rounded-xl shadow-sm"
            >
                <option value="">Todos los tipos</option>
                @foreach($tipoAnalisis as $t)
                    <option value="{{ $t->id }}" {{ $tipoAnalisisId == $t->id ? 'selected' : '' }}>
                        {{ $t->nombre }}
                    </option>
                @endforeach
            </x-form.input-select-filter>
        </div>

        {{-- Filtro Médicos (Ocupa 5/12 - Un poco más ancho para nombres largos) --}}
        <div wire:ignore class="sm:col-span-6 lg:col-span-5"> 
            <x-form.input-select-filter
                dataModel="doctorId"
                id="doctorSelect" 
                name="doctor" 
                label="Médico Solicitante"
                class="!bg-white dark:!bg-gray-800/50 border-gray-200 dark:border-gray-700 rounded-xl shadow-sm"
            >
                <option value="">Todos los doctores</option>
                @foreach($doctores as $d)
                    <option value="{{ $d->id }}" {{ $doctorId == $d->id ? 'selected' : '' }}>
                        {{ $d->getNombreCompletoAttribute() }}
                    </option>
                @endforeach
            </x-form.input-select-filter>
        </div>

        {{-- Filtro Estatus (Ocupa 3/12 - Más compacto) --}}
        <div wire:ignore class="sm:col-span-12 lg:col-span-3"> 
            <x-form.input-select-filter
                dataModel="estatusId"
                id="estatusSelect" 
                name="estatus" 
                label="Estatus"
                class="!bg-white dark:!bg-gray-800/50 border-gray-200 dark:border-gray-700 rounded-xl shadow-sm"
            >
                <option value="">Todos los estatus</option>
                @foreach($estatus as $e)
                    <option value="{{ $e->id }}" {{ $estatusId == $e->id ? 'selected' : '' }}>
                        {{ $e->nombre }}
                    </option>
                @endforeach
            </x-form.input-select-filter>
        </div>
    </x-slot:filters>

    <table class="min-w-full">
        <thead>
            <tr class="border-y border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-white/[0.02]">
                <th scope="col" class="px-4 py-3 text-start text-[10px] font-bold text-gray-400 uppercase tracking-widest">ID</th>
                <th scope="col" class="px-4 py-3 text-start text-[10px] font-bold text-gray-400 uppercase tracking-widest">Paciente / Doctor</th>
                <th scope="col" class="px-4 py-3 text-start text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estatus</th>
                <th scope="col" class="px-4 py-3 text-start text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden md:table-cell">Estudio</th>
                <th scope="col" class="px-4 py-3 text-start text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Muestra/Método</th>
                <th scope="col" class="px-4 py-3 text-start text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden xl:table-cell">Registro</th>
                <th scope="col" class="relative px-4 py-3 text-center text-[10px] font-bold text-gray-400 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-transparent">
            @forelse($analisis as $key => $a)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.01] transition-colors group">
                    {{-- ID con formato --}}
                    <td class="px-4 py-4 whitespace-nowrap text-xs font-mono text-gray-400">
                        #{{ str_pad($a->id, 5, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- Paciente y Doctor combinados para ahorrar espacio --}}
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                {{ $a->cliente->getNombreCompletoAttribute() }}
                            </span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="fa-solid fa-user-doctor text-[9px]"></i> {{ $a->doctor->getNombreCompletoAttribute() }}
                            </span>
                        </div>
                    </td>

                    {{-- Estatus con Badge Dinámico --}}
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span 
                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm border border-black/5"
                            style="background-color: {{ $a->estatus->color_fondo }}; color: {{ $a->estatus->color_texto }};"
                        >
                            <i class="fa-solid fa-circle text-[6px] mr-1.5 opacity-50"></i>
                            {{ $a->estatus->nombre }}
                        </span>
                    </td>

                    {{-- Estudio --}}
                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                        <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-tighter">
                            {{ $a->tipoAnalisis->nombre ?? 0}}
                        </div>
                    </td>

                    {{-- Muestra y Método combinados --}}
                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="fa-solid fa-vial text-[9px]"></i> {{ $a->tipoMuestra->nombre ?? "Sin muestra asignada" }}
                            </span>
                            <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="fa-solid fa-microscope text-[9px]"></i> {{ $a->tipoMetodo->nombre ?? "Sin muestra asignada" }}
                            </span>
                        </div>
                    </td>

                    {{-- Registro (Fecha y Usuario) --}}
                    <td class="px-4 py-4 whitespace-nowrap hidden xl:table-cell">
                        <div class="flex flex-col">
                            <span class="text-[11px] text-gray-600 dark:text-gray-400 font-medium">
                                {{ $a->created_at->format('d/m/Y') }}
                            </span>
                            <span class="text-[10px] text-gray-400 italic">
                                Por: {{ explode(' ', $a->usuarioCreacion->name)[0] }}
                            </span>
                        </div>
                    </td>

                    {{-- Acciones --}}
                    <td class="px-4 py-4 text-center whitespace-nowrap text-sm font-medium">
                        <div x-data="{ dropdownOpen: false }" class="relative inline-block">
                            <button 
                                @click="dropdownOpen = !dropdownOpen" 
                                x-ref="button"
                                type="button" 
                                class="p-2 rounded-xl text-gray-400 hover:bg-white dark:hover:bg-gray-800 hover:text-indigo-600 hover:shadow-sm transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-700"
                            >
                                <i class="fa-solid fa-ellipsis-vertical text-base"></i>
                            </button>

                            <template x-teleport="body">
                                <div 
                                    x-show="dropdownOpen" 
                                    @click.away="dropdownOpen = false"
                                    x-anchor.bottom-end.offset.5="$refs.button"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    class="z-[999] w-52 rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-sm shadow-2xl dark:border-gray-700 dark:bg-gray-900/95"
                                >
                                    <div class="p-2 space-y-1">
                                        <a href="{{ route('analisis.edit', $a->id) }}" class="flex items-center px-3 py-2.5 text-sm text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 rounded-xl transition-colors">
                                            <i class="fa-solid fa-flask-vial mr-3 text-indigo-500"></i>
                                            Resultados / Editar
                                        </a>
                                        <a href="{{ route('analisis.pdf', $a->id) }}" target="_blank" class="flex items-center px-3 py-2.5 text-sm text-gray-600 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 rounded-xl transition-colors">
                                            <i class="fa-solid fa-file-pdf mr-3 text-red-500"></i>
                                            Imprimir Reporte
                                        </a>
                                        <div class="h-px bg-gray-100 dark:bg-gray-800 my-1"></div>
                                        <button wire:click="confirmDelete({{ $a->id }})" class="flex w-full items-center px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors text-left font-semibold">
                                            <i class="fa-solid fa-trash-can mr-3"></i>
                                            Eliminar Análisis
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="h-20 w-20 rounded-3xl bg-gray-100 dark:bg-white/[0.02] flex items-center justify-center text-gray-300 mb-4">
                                <i class="fa-solid fa-microscope text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">No hay registros</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Prueba ajustando los filtros o crea un nuevo análisis.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/30 dark:bg-white/[0.01]">
        {{ $analisis->links() }}
    </div>
</x-form.table-filters>