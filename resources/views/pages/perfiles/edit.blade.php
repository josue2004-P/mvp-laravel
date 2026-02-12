@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="max-w-7xl mx-auto transition-colors duration-300 px-4 sm:px-6">
    
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6 border-b border-slate-200 dark:border-slate-800 pb-8">
        <div class="flex items-center gap-5">
            <div class="h-14 w-14 rounded-lg bg-[#001f3f] flex items-center justify-center text-white shadow-lg shadow-[#001f3f]/20 border border-[#001f3f]">
                <i class="fa-solid fa-gears text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-[0.2em]">Editar Perfil</h1>
                <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.15em] mt-1 flex items-center gap-2">
                    <span class="h-1 w-4 bg-[#001f3f]/30"></span>
                    Definiendo capacidades: <span class="text-[#001f3f] dark:text-blue-400 font-mono">{{ $perfil->nombre }}</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <x-form.link href="{{ route('perfiles.index') }}" class="group !text-slate-400 hover:!text-[#001f3f]">
                <i class="fa-solid fa-chevron-left mr-2 transition-transform group-hover:-translate-x-1 text-[8px]"></i> 
                Volver al listado
            </x-form.link>
        </div>
    </div>

    <form id="form-perfiles" action="{{ route('perfiles.update', $perfil) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-4 space-y-6">
                <x-common.component-card title="Identidad del Rol" desc="Especificaciones administrativas del perfil en el núcleo.">
                    <div class="space-y-6 py-2">
                        <div>
                            <x-form.input-label for="nombre" :value="__('Nombre ')" required class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest" />
                            <div class="mt-2 relative group">
                                <x-form.text-input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    class="w-full font-mono font-black text-[#001f3f] dark:text-blue-400"
                                    :value="old('nombre', $perfil->nombre)"
                                />    
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-700">
                                    <i class="fa-solid fa-terminal text-xs"></i>
                                </div>
                            </div>
                            <x-form.input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="descripcion" :value="__('Descripción ')" class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest" />
                            <x-form.text-input
                                type="text"
                                name="descripcion"
                                id="descripcion"
                                placeholder="Descripción"
                                class="w-full mt-2 font-mono uppercase text-[11px]"
                                :value="old('descripcion', $perfil->descripcion)"
                            />    
                            <x-form.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>
                    </div>

                    <x-slot:footer>
                        <x-ui.button size="md" type="submit" form="form-perfiles" class="w-full">
                            <i class="fa-solid text-lg fa-floppy-disk mr-2"></i>  Actualizar Registro
                        </x-ui.button>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            <div class="lg:col-span-8">
                    <div class="border border-slate-200 dark:border-slate-800 rounded-md overflow-hidden bg-white dark:bg-transparent">
                        <div class="hidden lg:grid lg:grid-cols-12 bg-slate-50 dark:bg-[#001f3f]/20 border-b border-slate-200 dark:border-slate-800">
                            <div class="col-span-6 px-5 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest">Módulo / Objeto</div>
                            <div class="col-span-6 px-5 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Nivel de Acceso</div>
                        </div>

                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($permisos as $permiso)
                                @php $pivot = $perfil->permisos->firstWhere('id', $permiso->id)?->pivot; @endphp

                                <div class="grid grid-cols-1 lg:grid-cols-12 items-center group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors">
                                    
                                    <div class="col-span-6 p-5 flex items-center gap-4 border-b lg:border-b-0 lg:border-r border-slate-100 dark:border-slate-800">
                                        <div class="h-8 w-8 rounded bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[#001f3f] dark:text-blue-400 border border-slate-200 dark:border-slate-700">
                                            <i class="fa-solid fa-cube text-[10px]"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-[11px] text-slate-900 dark:text-white uppercase tracking-wider">{{ $permiso->nombre }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-0.5">{{ $permiso->descripcion }}</p>
                                        </div>
                                    </div>

                                    <div class="col-span-6 p-4">
                                        <div class="flex flex-wrap items-center justify-center gap-3">
                                            {{-- Estructura de Checkbox Técnica --}}
                                            @foreach(['is_read' => 'Ver', 'is_create' => 'CREAR', 'is_update' => 'EDITAR', 'is_delete' => 'BORRAR'] as $key => $label)
                                                <label class="flex items-center px-2 py-1.5 rounded border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 cursor-pointer hover:border-[#001f3f] dark:hover:border-blue-500 transition-all group/opt">
                                                    <input type="checkbox" name="permisos[{{ $permiso->id }}][{{ $key }}]" {{ $pivot?->$key ? 'checked' : '' }}
                                                        class="h-3.5 w-3.5 rounded border-slate-300 text-[#001f3f] focus:ring-[#001f3f] dark:bg-slate-900 dark:border-slate-700">
                                                    <span class="ml-2 text-[9px] font-black uppercase tracking-widest text-slate-500 group-hover/opt:text-[#001f3f] dark:group-hover/opt:text-blue-400 transition-colors">{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </form>
</div>
@endsection