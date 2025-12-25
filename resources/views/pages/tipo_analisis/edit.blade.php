@extends('layouts.app')

@section('title', 'Editar Doctor')

@section('content')
<form id="form-tipo-analisis" action="{{ route('tipo_analisis.update', $tipoAnalisis) }}" method="POST" x-data="{ abierto: {} }" >
    <x-common.component-card title="Editar Tipo de Analisis" desc="Edita la información principal del Tipo de Analisis." grid="4" class="max-w-4xl ">
    @csrf
    @method('PUT')

        <div class="col-span-1">
            <x-form.input-label for="nombre" 
                :value="__('Nombre:')" />
            <x-form.text-input
                type="text"
                name="nombre"
                placeholder="Escribe el nombre"
                :value="$tipoAnalisis->nombre " 
                :messages="$errors->get('nombre')"
            />    
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Categorías -->
        <div class="col-span-4">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-400 mb-4">Hemogramas por Categoría</h3>
            @foreach($hemogramas->groupBy(fn($h) => $h->categoria->nombre ?? 'Sin categoría') as $categoria => $hemos)
                <div class="mb-4 border rounded-lg overflow-hidden">
                    <!-- Botón categoría -->
                    <div
                        class="
                            h-11 w-full rounded-lg border border-gray-300
                            bg-white px-4 py-2.5 text-sm text-gray-800
                            shadow-theme-xs
                            cursor-pointer flex justify-between items-center
                            transition
                            hover:bg-gray-50
                            focus-within:border-brand-300
                            focus-within:ring-3 focus-within:ring-brand-500/10
                            dark:border-gray-700 dark:bg-gray-900 dark:text-white/90
                        "
                        @click="abierto['{{ $categoria }}'] = !abierto['{{ $categoria }}']"
                    >
                        <span class="font-semibold text-gray-700 dark:text-white/80">
                            {{ $categoria }}
                        </span>

                        <span
                            x-text="abierto['{{ $categoria }}'] ? '−' : '+'"
                            class="font-bold text-gray-600 dark:text-white/60"
                        ></span>
                    </div>

                        <!-- Hemogramas -->
                    <div
                            x-show="abierto['{{ $categoria }}']"
                            x-transition
                            class="
                                mt-2
                                w-full rounded-lg border border-gray-300
                                bg-white
                                shadow-theme-xs
                                p-4
                                text-sm
                                dark:border-gray-700 dark:bg-gray-900
                            "
                        >
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($hemos as $hemograma)
                                    <label
                                            class="
                                                flex items-center gap-3
                                                h-11 w-full
                                                rounded-lg border border-gray-300
                                                bg-white
                                                px-4
                                                text-sm text-gray-800
                                                shadow-theme-xs
                                                cursor-pointer
                                                transition
                                                hover:bg-gray-50
                                                dark:border-gray-700 dark:bg-gray-900 dark:text-white/90
                                            "
                                        >
                                            <input
                                                type="checkbox"
                                                name="hemogramas[]"
                                                value="{{ $hemograma->id }}"
                                                {{ in_array($hemograma->id, $tipoAnalisis->hemogramas->pluck('id')->toArray()) ? 'checked' : '' }}
                                                class="form-checkbox h-5 w-5 text-indigo-600"
                                            >

                                            <span class="truncate">
                                                {{ $hemograma->nombre }}
                                            </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                </div>
            @endforeach
        </div>

        <!-- Botones -->
        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <a href="{{ route('tipo_analisis.index') }}"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700  hover:bg-gray-200 transition">
                    Cancelar
                </a>
                <x-ui.button size="sm" type="submit" form="form-tipo-analisis">
                    Guardar
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-common.component-card>
</form>
@endsection
