<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">Editar Doctor</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-8">
        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-200">
            <!-- Título del formulario -->
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-extrabold text-indigo-700">Editar Doctor</h1>
                <p class="text-gray-500 text-sm mt-2">Modifica la información del doctor y guarda los cambios.</p>
            </div>

            <form action="{{ route('doctores.update', $doctor) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">👤</span>
                        <input type="text" name="nombre" value="{{ old('nombre', $doctor->nombre) }}"
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Nombre completo" required>
                    </div>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- <!-- Especialidad -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Especialidad</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🏥</span>
                        <input type="text" name="especialidad" value="{{ old('especialidad', $doctor->especialidad) }}"
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Ej: Cardiología" required>
                    </div>
                    @error('especialidad')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cédula -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Cédula Profesional</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📄</span>
                        <input type="text" name="cedula" value="{{ old('cedula', $doctor->cedula) }}"
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Número de cédula" required>
                    </div>
                    @error('cedula')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Teléfono</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📞</span>
                        <input type="text" name="telefono" value="{{ old('telefono', $doctor->telefono) }}"
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="Ej: +52 555 123 4567">
                    </div>
                    @error('telefono')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Correo -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Correo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">✉️</span>
                        <input type="email" name="correo" value="{{ old('correo', $doctor->correo) }}"
                               class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                               placeholder="correo@ejemplo.com">
                    </div>
                    @error('correo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Activo -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Activo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">✅</span>
                        <select name="activo"
                                class="w-full pl-10 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <option value="1" {{ $doctor->activo ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ !$doctor->activo ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div> --}}

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('doctores.index') }}" 
                       class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold shadow-md hover:from-green-700 hover:to-emerald-600 transition">
                        Actualizar Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
