@extends('layouts.app')

@section('title', 'Crear Perfil')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="mb-6 sm:mb-10 flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-5 text-center sm:text-left">
        <div class="h-14 w-14 flex-shrink-0 rounded-lg bg-[#001f3f] flex items-center justify-center text-white border border-[#001f3f] shadow-lg shadow-[#001f3f]/10">
            <i class="fa-solid fa-shield-halved text-xl"></i>
        </div>
        
        <div class="w-full">
            <h1 class="text-lg sm:text-xl font-black text-slate-950 dark:text-white uppercase tracking-[0.15em] sm:tracking-[0.2em]">
                Crear Permiso
            </h1>
            <div class="flex flex-col sm:flex-row items-center gap-2 mt-1">
                <span class="hidden sm:block h-[1px] w-8 bg-[#001f3f]/30"></span>
                <p class="text-[9px] sm:text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                    <i class="fa-solid fa-microchip text-[9px] text-[#001f3f]/50"></i>
                    Protocolo de Seguridad
                </p>
            </div>
        </div>
    </div>

    <form id="form-permisos" action="{{ route('permisos.store') }}" method="POST">
        @csrf
        <x-common.component-card 
            title="Definición de Especificación Técnica" 
            desc="Configure el identificador único para el control de middleware." 
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 sm:gap-y-8 py-2 sm:py-4">
                {{-- Identificador --}}
                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Nombre')" required class="text-[9px] sm:text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest"/>
                    <div class="mt-2 relative group">
                        {{-- Tu x-form.text-input ya tiene el diseño base azul por defecto --}}
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="MODULO"
                            :value="old('nombre')"
                            class="font-mono w-full"
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#001f3f] dark:group-focus-within:text-blue-400 transition-colors">
                            <i class="fa-solid fa-code text-xs"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-2 text-[8px] sm:text-[9px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-widest flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-[#001f3f]/40 dark:text-blue-500/40"></i> Estructura: objeto
                    </p>
                </div>

                {{-- Descripción --}}
                <div class="col-span-1">
                    <x-form.input-label for="descripcion" :value="__('Descripción')" class="text-[9px] sm:text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest" />
                    <div class="mt-2">
                        <x-form.text-input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            placeholder="DESCRIPCIÓN"
                            :value="old('descripcion')"
                           class="font-mono w-full"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                {{-- Nota de Seguridad --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4 p-4 sm:p-5 border border-slate-200 bg-slate-50/50 dark:bg-slate-950/40 dark:border-slate-800 transition-all">
                        <div class="mt-0.5 flex-shrink-0 text-[#001f3f] dark:text-blue-400">
                            <i class="fa-solid fa-terminal text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-[9px] sm:text-[10px] font-black text-[#001f3f] dark:text-blue-400 uppercase tracking-widest">Aviso de Configuración</h4>
                            <p class="mt-1 text-[10px] sm:text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed font-medium italic">
                                La persistencia afectará la <span class="font-bold text-slate-900 dark:text-white underline decoration-[#001f3f]/30">Matriz de Acceso</span>. Verifique duplicados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 py-2 bg-slate-50/30 dark:bg-transparent">
                    <a href="{{ route('permisos.index') }}"
                        class="w-full sm:w-auto text-center text-[9px] sm:text-[10px] font-black text-slate-400 hover:text-rose-700 dark:text-slate-500 dark:hover:text-rose-500 uppercase tracking-widest transition-colors duration-200 flex items-center justify-center group">
                        <i class="fa-solid fa-chevron-left mr-2 transition-transform group-hover:-translate-x-1 text-[8px]"></i> Descartar 
                    </a>
                    <x-ui.button 
                        type="submit" 
                        form="form-permisos" 
                        variant="primary" 
                        size="md"
                        class="w-full sm:w-auto"
                    >
                        <x-slot:startIcon>
                            <i class="fa-solid text-lg fa-floppy-disk"></i>
                        </x-slot:startIcon>
                        
                        Guardar Registro
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection