<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Perfil</h2>
    </x-slot>

    <form action="{{ route('perfiles.update', $perfil) }}" method="POST" class="max-w-7xl mx-auto">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            {{-- CARD: Información del perfil --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-indigo-800 mb-4">Información del Perfil</h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ $perfil->nombre }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                        rows="3">{{ $perfil->descripcion }}</textarea>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('perfiles.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                    <button
                        class="ml-4 inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Actualizar
                    </button>
                </div>
            </div>

            {{-- CARD: Permisos asignados --}}
            <div class="bg-white rounded-lg shadow-md p-6 h-fit">
                <h3 class="text-lg font-semibold text-indigo-800 mb-4">Permisos Asignados</h3>

                <div class="grid grid-cols-1 gap-4">
                    @foreach($permisos as $permiso)
                        <label 
                        class="bg-indigo-50 border border-indigo-200 hover:border-indigo-400 transition-all duration-150 shadow-sm rounded-lg p-4 flex items-start gap-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="permisos[]" 
                                value="{{ $permiso->id }}" 
                                {{ $perfil->permisos->contains($permiso->id) ? 'checked' : '' }}
                                class="mt-1 accent-indigo-600"
                            >
                            <div>
                                <p class="font-medium text-indigo-800">{{ $permiso->nombre }}</p>
                                <p class="text-sm text-indigo-600">{{ $permiso->descripcion }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
