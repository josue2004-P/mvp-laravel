<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Editar Perfil</h2>
    </x-slot>

    <form action="{{ route('perfiles.update', $perfil) }}" method="POST" class="max-w-7xl mx-auto">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- CARD: Información del perfil --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                
                <!-- Header interno -->
                <div class="mb-6 text-center">
                    <h1 class="text-2xl font-bold text-indigo-700">Información del Perfil</h1>
                    <p class="text-gray-500 text-sm mt-1">Edita los datos del perfil y guarda los cambios.</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ $perfil->nombre }}"
                        class="w-full pl-3 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition px-4 py-2" required>
                    @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                    <textarea name="descripcion"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 transition"
                        rows="3">{{ $perfil->descripcion }}</textarea>
                    @error('descripcion')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end mt-6 gap-4">
                    <a href="{{ route('usuarios.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg font-semibold shadow-md hover:from-green-600 hover:to-emerald-700 transition">
                        Actualizar
                    </button>
                </div>
            </div>

            {{-- CARD: Permisos asignados --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 h-fit">
                
                <!-- Header interno permisos -->
                <div class="mb-4 text-center">
                    <h2 class="text-xl font-semibold text-indigo-700">Permisos Asignados</h2>
                    <p class="text-gray-500 text-sm mt-1">Selecciona los permisos que se asignarán a este perfil.</p>
                </div>

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
