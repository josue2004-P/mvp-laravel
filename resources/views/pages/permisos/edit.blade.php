@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="mb-6 sm:mb-10 flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-5 text-center sm:text-left">
        <div class="h-14 w-14 flex-shrink-0 rounded-lg bg-[#001f3f] flex items-center justify-center text-white border border-[#001f3f] shadow-lg shadow-[#001f3f]/10">
            <i class="fa-solid fa-pen-to-square text-xl"></i>
        </div>
        
        <div class="w-full">
            <h1 class="text-lg sm:text-xl font-black text-slate-950 dark:text-white uppercase tracking-[0.15em] sm:tracking-[0.2em]">
                Editar Permiso
            </h1>
            <div class="flex flex-col sm:flex-row items-center gap-2 mt-1">
                <span class="hidden sm:block h-[1px] w-8 bg-[#001f3f]/30"></span>
                <p class="text-[9px] sm:text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                    Ref: <span class="font-mono text-[#001f3f] dark:text-blue-400">{{ $permiso->nombre }}</span>
                </p>
            </div>
        </div>
    </div>

    <form id="form-permisos" action="{{ route('permisos.update', $permiso) }}" method="POST">
        @csrf
        @method('PUT')

        <x-common.component-card 
            title="Editar Permiso" 
            desc="Asegúrese de que el identificador editado coincida con las directivas @can o Middleware en su código fuente." 
            class="!rounded-lg border-slate-300 dark:border-slate-800 dark:bg-slate-900/50"
        >

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6 sm:gap-y-8 py-2 sm:py-4">
                {{-- Identificador --}}
                <div class="col-span-1">
                    <x-form.input-label for="nombre" :value="__('Nombre')" required class="text-[9px] sm:text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest"/>
                    <div class="mt-2 relative group">
                        <x-form.text-input
                            id="nombre"
                            type="text"
                            name="nombre"
                            placeholder="MODULO"
                            :value="old('nombre', $permiso->nombre)"
                            class="font-mono w-full"
                        />
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[#001f3f] transition-colors">
                            <i class="fa-solid fa-code text-xs"></i>
                        </div>
                    </div>
                    <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                    <p class="mt-2 text-[8px] sm:text-[9px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-widest flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-[#001f3f]/40"></i> Formato sugerido: objeto
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
                            :value="old('descripcion', $permiso->descripcion)"
                           class="font-mono w-full"
                        />
                    </div>
                    <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                {{-- Nota de Seguridad Crítica (Cambiado a tono de advertencia técnica) --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4 p-4 sm:p-5 border border-rose-200 bg-rose-50/30 dark:bg-rose-950/20 dark:border-rose-900/30 transition-all">
                        <div class="mt-0.5 flex-shrink-0 text-rose-600">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <h4 class="text-[9px] sm:text-[10px] font-black text-rose-800 dark:text-rose-400 uppercase tracking-widest">Alerta de Integridad</h4>
                            <p class="mt-1 text-[10px] sm:text-[11px] text-rose-700 dark:text-rose-500 leading-relaxed font-medium italic">
                                La modificación del identificador puede <span class="font-bold underline">romper el control de acceso</span> en tiempo real si el código fuente no se actualiza.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 py-2 bg-slate-50/30 dark:bg-transparent">
                    <x-form.link href="{{ route('permisos.index') }}" class="flex items-center group !text-slate-400 hover:!text-rose-600">
                        <i class="fa-solid fa-chevron-left mr-2 transition-transform group-hover:-translate-x-1 text-[8px]"></i> 
                        Descartar Cambios
                    </x-form.link>
                    
                    <x-ui.button size="md" type="submit" form="form-permisos" class="w-full sm:w-auto">
                        <i class="fa-solid text-lg fa-floppy-disk mr-2"></i> Actualizar Registro
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection