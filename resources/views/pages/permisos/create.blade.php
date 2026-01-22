@extends('layouts.app')

@section('title', 'Registrar Nuevo Permiso')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header con Iconografía Técnica --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-12 w-12 rounded-2xl bg-zinc-900 flex items-center justify-center text-zinc-400 shadow-xl shadow-zinc-200 dark:shadow-none border border-zinc-800">
            <i class="fa-solid fa-key text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Registro de Llaves de Acceso</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Define las constantes de seguridad para los módulos del sistema.</p>
        </div>
    </div>

    <form id="form-permisos" action="{{ route('permisos.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Definición de Permiso" desc="Estas llaves son utilizadas por el Middleware para restringir accesos." class="shadow-theme-md">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nombre / Clave del Permiso --}}
                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Identificador (Clave)')" required/>
                    <div class="mt-1 relative group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: reportes.ver"
                            :value="old('nombre')"
                            class="lowercase w-full font-mono text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500/20"
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-500 transition-colors">
                            <i class="fa-solid fa-code text-xs"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-2 text-[10px] text-gray-400 uppercase font-bold tracking-[0.15em]">
                        <i class="fa-solid fa-circle-info mr-1"></i> Formato sugerido: modulo.accion
                    </p>
                </div>

                {{-- Descripción --}}
                <div class="col-span-1">
                    <x-form.input-label for="descripcion" :value="__('Descripción del Alcance')" />
                    <div class="mt-1">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="Breve explicación de la capacidad"
                            :value="old('descripcion')"
                            class="w-full"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                {{-- Notificación de Impacto --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20">
                        <div class="mt-1 flex-shrink-0 h-8 w-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-500">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-amber-900 dark:text-amber-400 uppercase tracking-widest">Nota de Seguridad</h4>
                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-500/80 leading-relaxed italic">
                                Una vez creado el permiso, este aparecerá automáticamente en la <span class="font-bold">Matriz de Perfiles</span>. Evite renombrar permisos existentes, ya que esto podría invalidar los accesos de los usuarios actuales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between">
                    <a href="{{ route('permisos.index') }}"
                        class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors duration-200">
                        <i class="fa-solid fa-xmark mr-2"></i> Cancelar Registro
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-permisos" class="shadow-lg shadow-indigo-500/20">
                        <i class="fa-solid fa-key-skeleton mr-2"></i> Crear Llave de Acceso
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection