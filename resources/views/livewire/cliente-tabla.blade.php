<x-form.table-filters 
    title="Listado de Clientes"
    :search="$search"
    :perPage="$perPage"
    :createRoute="route('clientes.create')"
>
   <x-slot:filters>
   </x-slot:filters>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02]">
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">ID</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Paciente / Contacto</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nacimiento</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400 hidden lg:table-cell">Ubicación</th>
                    <th scope="col" class="px-6 py-4 text-start text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Estatus</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider dark:text-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-transparent">
                @forelse($clientes as $cliente)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-500/5 transition-all duration-200">
                        {{-- ID Mono --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400 dark:text-gray-500">
                            <span class="opacity-50">#</span>{{ str_pad($cliente->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Identidad --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="relative inline-flex items-center justify-center flex-shrink-0 h-11 w-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 shadow-md shadow-indigo-200 dark:shadow-none transition-transform group-hover:scale-105">
                                    <span class="text-white font-extrabold text-xs tracking-tighter">
                                        {{ strtoupper(substr($cliente->nombre, 0, 1)) }}{{ strtoupper(substr($cliente->apellido_paterno, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                        {{ $cliente->getNombreCompletoAttribute() }} 
                                    </div>
                                    <div class="flex items-center text-[10px] font-medium text-gray-500 dark:text-gray-400 mt-0.5 lowercase tracking-tight">
                                        <i class="fa-regular fa-envelope mr-1.5 opacity-60"></i>
                                        {{ $cliente->email ?? 'Sin correo' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Cumpleaños --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <div class="flex items-center text-sm font-bold text-gray-700 dark:text-gray-200">
                                    <i class="fa-solid fa-cake-candles mr-2 text-orange-400 opacity-80 text-xs"></i>
                                    {{ $cliente->fecha_nacimiento ? \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                </div>
                                @if($cliente->fecha_nacimiento)
                                    <span class="text-[10px] text-gray-400 font-medium ml-5 italic">
                                        {{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->age }} años
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Localización --}}
                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                           <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 font-medium tracking-tight">
                               <i class="fa-solid fa-location-dot mr-2.5 opacity-40 text-indigo-500"></i>
                               {{ $cliente->ciudad ?? 'N/A' }}, <span class="ml-1 opacity-60">{{ $cliente->estado ?? '-' }}</span>
                           </div>
                        </td>

                        {{-- Estatus --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($cliente->is_activo)
                                <div class="flex items-center text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">
                                    <span class="w-2 h-2 mr-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Activo
                                </div>
                            @else
                                <div class="flex items-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                                    <span class="w-2 h-2 mr-2.5 rounded-full bg-gray-300"></span>
                                    Suspendido
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
                                            Ficha de Paciente
                                        </div>
                                        <div class="space-y-0.5">
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="flex items-center px-3 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors group/item">
                                                <i class="fa-solid fa-id-card-clip mr-3 text-gray-400 group-hover/item:text-indigo-500 transition-colors"></i>
                                                Ver Expediente
                                            </a>
                                            <div class="my-1 border-t border-gray-50 dark:border-gray-800"></div>
                                            <button 
                                                wire:click="confirmDelete({{ $cliente->id }})" 
                                                class="flex w-full items-center px-3 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-colors group/del"
                                            >
                                                <i class="fa-solid fa-user-minus mr-3 text-red-400 group-hover/del:text-red-500 transition-colors"></i>
                                                Eliminar Cliente
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-indigo-50 dark:bg-white/[0.02] rounded-full flex items-center justify-center mb-4 border border-indigo-100 dark:border-white/5">
                                    <i class="fa-solid fa-hospital-user text-3xl text-indigo-200 dark:text-indigo-900"></i>
                                </div>
                                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white uppercase tracking-tight">Sin registros de pacientes</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto mt-1 italic">
                                    No hay resultados que coincidan con la búsqueda actual.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($clientes->hasPages())
        <div class="px-6 py-5 bg-gray-50/30 dark:bg-transparent border-t border-gray-200 dark:border-gray-800">
            {{ $clientes->links() }}
        </div>
    @endif
</x-form.table-filters>