<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Crear Hemograma Completo</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200">
            
            <!-- Título del formulario -->
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-extrabold text-indigo-700">Registrar Hemograma Completo</h1>
                <p class="text-gray-500 text-sm mt-2">Completa la información para crear un nuevo hemograma completo.</p>
            </div>

            <form action="{{ route('hemograma_completo.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-1 gap-5">
                @csrf

                <!-- Nombre -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📝</span>
                        <input type="text" name="nombre" 
                               value="{{ old('nombre') }}" 
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" 
                               placeholder="Ej. Hemoglobina"
                               required>
                    </div>
                    @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Categoría</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center  pl-3 text-gray-400">📂</span>
                        <select name="idCategoriaHemogramaCompleto" 
                                class="w-full pl-10 border border-gray-300 rounded-lg px-10 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" 
                                required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->id }}" {{ old('idCategoriaHemogramaCompleto') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('idCategoriaHemogramaCompleto')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Unidad -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Unidad</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">⚖️</span>
                        <select name="idUnidad" 
                                class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" 
                                required>
                            <option value="">Selecciona una unidad</option>
                            @foreach($unidades as $u)
                                <option value="{{ $u->id }}" {{ old('idUnidad') == $u->id ? 'selected' : '' }}>
                                    {{ $u->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('idUnidad')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Referencia -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Referencia</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📏</span>
                        <input type="text" name="referencia" 
                               value="{{ old('referencia') }}" 
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" 
                               placeholder="Ej. 13.5 - 17.5 g/dL"
                               required>
                    </div>
                    @error('referencia')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Botones (en ancho completo) -->
                <div class="md:col-span-2 flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('hemograma_completo.index') }}" 
                       class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-blue-600 transition">
                        Guardar Hemograma
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
