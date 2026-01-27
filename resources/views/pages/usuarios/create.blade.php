@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-0 transition-colors duration-300">
    {{-- Encabezado Externo --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Registrar Nuevo Usuario</h1>
        <p class="text-base text-slate-500 dark:text-slate-400 mt-1">Configura las credenciales y el estado de acceso para el nuevo miembro del equipo.</p>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <x-common.component-card title="Información de Cuenta" desc="Define los datos personales y el nivel de acceso inicial." class="shadow-xl border-slate-200 dark:border-slate-800">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8 py-2">
                
                {{-- Nombre Completo --}}
                <div class="col-span-1">
                    <x-form.input-label for="name" :value="__('Nombre Completo')" required class="text-slate-700 dark:text-slate-300 font-bold mb-2"/>
                    <x-form.text-input
                        id="name"
                        type="text"
                        name="name"
                        placeholder="Ej. Pedro Picapiedra"
                        class="w-full"
                        :value="old('name')"
                    />
                    <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Correo Electrónico --}}
                <div class="col-span-1">
                    <x-form.input-label for="email" :value="__('Correo Electrónico')" required class="text-slate-700 dark:text-slate-300 font-bold mb-2"/>
                    <x-form.text-input
                        id="email"
                        type="email"
                        name="email"
                        class="lowercase w-full" 
                        placeholder="usuario@dominio.com"
                        :value="old('email')" 
                    />
                    <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Control de Estado (is_activo) Mejorado --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center justify-between p-5 rounded-2xl border border-emerald-100 bg-emerald-50/30 dark:border-emerald-500/10 dark:bg-emerald-500/5 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-emerald-600 border border-emerald-100 dark:border-emerald-900/50">
                                <i class="fa-solid fa-user-shield text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Estado de la Cuenta</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">¿Permitir el acceso inmediato al sistema tras el registro?</p>
                            </div>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_activo" value="1" class="sr-only peer" {{ old('is_activo', '1') == '1' ? 'checked' : '' }}>
                            <div class="w-14 h-7 bg-slate-200 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-500 shadow-inner"></div>
                            <span class="ml-3 text-[11px] font-bold uppercase tracking-widest text-slate-400 peer-checked:text-emerald-600 dark:peer-checked:text-emerald-400 transition-colors">
                                Habilitada
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Separador Visual --}}
                <div class="col-span-1 md:col-span-2 border-t border-slate-100 dark:border-slate-800/50 my-2 pt-6">
                    <h3 class="text-[11px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.25em]">Credenciales de Seguridad</h3>
                </div>

                {{-- Contraseña --}}
                <div class="col-span-1">
                    <x-form.input-label for="password" :value="__('Contraseña Temporal')" required class="text-slate-700 dark:text-slate-300 font-bold mb-2"/>
                    <x-form.text-input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Mínimo 8 caracteres"
                        class="w-full"
                    />
                    <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirmación --}}
                <div class="col-span-1">
                    <x-form.input-label for="password_confirmation" :value="__('Confirmar Contraseña')" required class="text-slate-700 dark:text-slate-300 font-bold mb-2"/>
                    <x-form.text-input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="Repite la contraseña"
                        class="w-full"
                    />
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-between py-2">
                    <a href="{{ route('usuarios.index') }}"
                        class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 transition-all active:scale-95">
                        <i class="fa-solid fa-arrow-left-long mr-2"></i> Cancelar Registro
                    </a>
                    
                    <x-ui.button size="sm" type="submit" form="form-usuarios" class="shadow-emerald-900/20">
                        <i class="fa-solid fa-user-plus mr-2"></i> Crear y Guardar
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-common.component-card>
    </form>
</div>
@endsection