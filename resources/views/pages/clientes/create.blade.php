<x-app-layout>
    <div class="max-w-2xl mt-10 mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 p-10">
        
        <!-- Encabezado -->
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-indigo-700">Crear Cliente</h2>
            <p class="text-gray-500 text-sm mt-2">Completa la información para registrar un nuevo cliente.</p>
        </div>

        <form action="{{ route('clientes.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        👤
                    </span>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                           placeholder="Ingresa el nombre" required>
                </div>
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Edad -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Edad</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        🎂
                    </span>
                    <input type="number" name="edad" value="{{ old('edad') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                           placeholder="Ejemplo: 25" required>
                </div>
                @error('edad')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sexo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sexo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        ⚧️
                    </span>
                    <select name="sexo"
                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                            required>
                        <option value="">Seleccione...</option>
                        <option value="MASCULINO" {{ old('sexo') == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                        <option value="FEMENINO" {{ old('sexo') == 'FEMENINO' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                @error('sexo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Divider -->
            <hr class="my-6 border-gray-200">

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('clientes.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-blue-600 transition">
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
