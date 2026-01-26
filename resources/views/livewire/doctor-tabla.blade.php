<x-form.table-filters 
    title="Listado de Especialistas"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('doctores.create')"
>
    <x-slot:filters>
        <div wire:ignore class="sm:col-span-6 lg:col-span-4 xl:col-span-5"> 
            <div class="relative group">
                <x-form.input-select-filter
                    id="especialidadSelect" 
                    name="especialidad" 
                    dataModel="especialidadId" 
                    label="Especialidad Médica"
                    class="!bg-white dark:!bg-gray-800/50 border-gray-200 dark:border-gray-700 rounded-xl shadow-sm focus:ring-indigo-500/20 transition-all"
                >
                    <option value="">Todas las especialidades</option>
                    @foreach($especialidades as $es)
                        <option value="{{ $es->id }}">
                            {{ $es->nombre }}
                        </option>
                    @endforeach
                </x-form.input-select-filter>
            </div>
        </div>
    </x-slot:filters>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">ID</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Doctor / Cédula</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Especialidad</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Estatus</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-transparent">
                @forelse($doctores as $doctor)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-all duration-200">
                        {{-- ID --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400 dark:text-gray-500">
                            #{{ str_pad($doctor->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Médico --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="relative inline-flex items-center justify-center flex-shrink-0 h-11 w-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-md shadow-indigo-200 dark:shadow-none">
                                    <i class="fa-solid fa-user-md text-white text-sm"></i>
                                    @if($doctor->is_activo)
                                        <span class="absolute -bottom-1 -right-1 h-3.5 w-3.5 rounded-full border-2 border-white dark:border-gray-900 bg-emerald-500"></span>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-extrabold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                        {{ $doctor->getNombreCompletoAttribute() }}
                                    </div>
                                    <div class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-tighter">
                                        CP: {{ $doctor->cedula_profesional }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Especialidad --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                @forelse($doctor->especialidades as $especialidad)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">
                                        {{ $especialidad->nombre }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-gray-50 text-gray-500 dark:bg-gray-800 dark:text-gray-400 border border-gray-100 dark:border-gray-700">
                                        Sin Especialidad
                                    </span>
                                @endforelse
                            </div>
                        </td>
                        {{-- Estatus --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($doctor->is_activo)
                                <div class="flex items-center text-[11px] font-bold text-emerald-600 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 mr-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Disponible
                                </div>
                            @else
                                <div class="flex items-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 mr-2 rounded-full bg-gray-300"></span>
                                    Inactivo
                                </div>
                            @endif
                        </td>

                        {{-- Acciones --}}
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
                                            Médico Especialista
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('doctores.edit', $doctor->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-user-doctor mr-3 text-gray-400 group-hover/item:text-indigo-500 transition-colors"></i>
                                                Editar Perfil
                                            </a>
                                            
                                            {{-- Espacio para ver agenda o análisis solicitados en el futuro --}}
                                            {{-- <a href="#" class="flex items-center px-3 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-file-medical mr-3 text-gray-400 group-hover/item:text-indigo-500 transition-colors"></i>
                                                Historial Médico
                                            </a> --}}

                                            @if(checkPermiso('doctores.is_delete') || checkPermiso('administrador.is_delete'))

                                            <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>
                                            
                                            <button 
                                                wire:click="confirmDelete({{ $doctor->id }})" 
                                                class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors group/del"
                                            >
                                                <i class="fa-solid fa-trash-can mr-3 text-red-400 group-hover/del:text-red-500 transition-colors"></i>
                                                Eliminar Doctor
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- EMPTY STATE MEJORADO (Igual al de Tipos de Métodos) --}}
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 rounded-full bg-indigo-50 dark:bg-white/5 mb-4 border border-indigo-100 dark:border-indigo-900/30">
                                    <i class="fa-solid fa-user-doctor text-3xl text-indigo-200 dark:text-indigo-800"></i>
                                </div>
                                <h3 class="text-gray-900 dark:text-white font-extrabold uppercase tracking-tight">Sin Especialistas</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto mt-1">
                                    No se encontraron médicos registrados o que coincidan con los filtros aplicados.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-form.table-filters>