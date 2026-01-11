<div class="rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
    
    <div class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Tipo de Muestra</h3>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <a 
                href="{{ route('tipo_muestra.create') }}"
                type="button" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none dark:focus:ring-primary-800">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Nuevo Tipo de Muestra
            </a>
            <form wire:submit.prevent="render"> 
                <div class="relative">
                    <button type="submit" class="absolute -translate-y-1/2 left-4 top-1/2">
                        <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill=""/>
                        </svg>
                    </button>
                    <input type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Search..." 
                        class="h-[42px] w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-[42px] pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-blue-800 xl:w-[300px]"/>
                </div>
            </form>
        </div>
    </div>

        <div class="">
        <div class="max-w-full px-5">
            <table class="min-w-full">
                <thead>
                    <tr class="border-gray-200 border-y dark:border-gray-700">
                        <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Id</th>
                        <th scope="col" class="px-4 py-3 font-normal text-gray-500 text-start text-theme-sm dark:text-gray-400">Nombre</th>
                        <th scope="col" class="relative px-4 py-3 capitalize">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    {{-- Livewire/Blade reemplaza a x-for --}}
                    @forelse($muestras as $tipo)
                    <tr>
                        <td class="py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $tipo['id'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $tipo['nombre'] }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                            {{-- Mantener la lógica de Alpine para el dropdown (si es compleja) es común --}}
                        <div x-data="{ dropdownOpen: false }" class="flex justify-center relative">
                            <button @click="dropdownOpen = !dropdownOpen" type="button" class="text-gray-500 dark:text-gray-400">
                                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                        fill="currentColor"/>
                                </svg>
                            </button>

                            <div 
                                x-show="dropdownOpen" 
                                @click.away="dropdownOpen = false"
                                x-transition
                                class="absolute right-0 z-60 mt-10 w-44 rounded-xl border 
                                    border-gray-200 bg-white shadow-lg py-1
                                    dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
                            >
                                <a 
                                    href="{{ route('tipo_muestra.edit',$tipo['id']) }}"

                                class="flex w-full px-3 py-2 font-medium text-left text-gray-600 dark:text-gray-300 
                                        rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" >
                                    View More ({{ $tipo['id'] }})
                                </a>

                                <button 
                                    wire:click="confirmDelete({{ $tipo['id'] }})"
                                    class="flex w-full px-3 py-2 font-medium text-left text-red-600 dark:text-red-400 
                                        rounded-lg hover:bg-red-100 dark:hover:bg-red-500/20"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-3 text-center text-gray-500">
                            No se encontraron transacciones.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="px-6 py-4 border-t border-gray-200 dark:border-white/[0.05]">
        {{ $muestras->links() }}
    </div>

</div>
