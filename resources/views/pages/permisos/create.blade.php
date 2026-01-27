@extends('layouts.app')

@section('title', 'Registrar Nuevo Permiso')

@section('content')
<div class="max-w-4xl mx-auto transition-colors duration-300">
    {{-- Header con Iconografía Técnica Emerald --}}
    <div class="mb-8 flex items-center gap-4">
        <div class="h-12 w-12 rounded-2xl bg-slate-900 flex items-center justify-center text-emerald-500 shadow-xl shadow-slate-200 dark:shadow-none border border-slate-800">
            <i class="fa-solid fa-key text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Registro de Llaves de Acceso</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Define las constantes de seguridad para los módulos del sistema.</p>
        </div>
    </div>

    <form id="form-permisos" action="{{ route('permisos.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Definición de Permiso" desc="Estas llaves son utilizadas por el Middleware para restringir accesos." class="shadow-xl border-slate-200 dark:border-slate-800">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-2">
                {{-- Nombre / Clave del Permiso --}}
                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Identificador (Clave)')" required class="font-bold text-slate-700 dark:text-slate-300"/>
                    <div class="mt-1 relative group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="ej: reportes.ver"
                            :value="old('nombre')"
                            class="lowercase w-full font-mono text-emerald-600 dark:text-emerald-400 focus:ring-emerald-500/20"
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors">
                            <i class="fa-solid fa-code text-xs"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-2 text-[10px] text-slate-400 uppercase font-bold tracking-[0.15em]">
                        <i class="fa-solid fa-circle-info mr-1 text-emerald-500"></i> Formato sugerido: modulo.accion
                    </p>
                </div>

                {{-- Descripción --}}
                <div class="col-span-1">
                    <x-form.input-label for="descripcion" :value="__('Descripción del Alcance')" class="font-bold text-slate-700 dark:text-slate-300" />
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

                {{-- Notificación de Impacto Refinada --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200/50 dark:border-amber-900/30 transition-all">
                        <div class="mt-1 flex-shrink-0 h-9 w-9 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-600 dark:text-amber-500">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-amber-800 dark:text-amber-400 uppercase tracking-widest">Nota de Seguridad</h4>
                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-500/80 leading-relaxed italic">
                                Una vez creado el permiso, este aparecerá automáticamente en la <span class="font-bold text-slate-800 dark:text-slate-200">Matriz de Perfiles</span>. Evite renombrar permisos existentes para no invalidar accesos actuales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between py-2">
                    <a href="{{ route('permisos.index') }}"
                        class="text-sm font-bold text-slate-400 hover:text-rose-500 transition-colors duration-200 flex items-center group">
                        <i class="fa-solid fa-arrow-left-long mr-2 transition-transform group-hover:-translate-x-1"></i> Cancelar Registro
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-permisos" class="shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-key-skeleton mr-2"></i> Crear Llave de Acceso
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection