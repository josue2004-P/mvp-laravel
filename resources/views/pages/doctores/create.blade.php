<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">Crear Doctor</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-10">
        
        <!-- Encabezado interno -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-700">Registrar Doctor</h1>
            <p class="text-gray-500 text-sm mt-2">Completa la información del nuevo doctor.</p>
        </div>

        <form action="{{ route('doctores.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">👤</span>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Nombre completo" required>
                </div>
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- <!-- Especialidad -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Especialidad</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🏥</span>
                    <input type="text" name="especialidad" value="{{ old('especialidad') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Ej: Cardiología" required>
                </div>
                @error('especialidad')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Cédula profesional -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Cédula Profesional</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📄</span>
                    <input type="text" name="cedula" value="{{ old('cedula') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Número de cédula" required>
                </div>
                @error('cedula')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">📞</span>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="Ej: +52 555 123 4567">
                </div>
                @error('telefono')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Correo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Correo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">✉️</span>
                    <input type="email" name="correo" value="{{ old('correo') }}"
                           class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           placeholder="correo@ejemplo.com">
                </div>
                @error('correo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Activo -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Activo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">✅</span>
                    <select name="activo"
                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="1" {{ old('activo', 1) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('activo') == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div> --}}

            <!-- Botones -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('doctores.index') }}"
                   class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-semibold shadow-md hover:from-indigo-700 hover:to-blue-600 transition">
                    Guardar Doctor
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
