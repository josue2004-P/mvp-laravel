@extends('layouts.app')

@section('title', 'Configurar Cuenta de Usuario')

@section('content')
<div class="max-w-7xl mx-auto transition-colors duration-300">
    {{-- Encabezado con Identidad Emerald --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-5">
            {{-- Avatar Emerald --}}
            <div class="h-16 w-16 rounded-3xl bg-emerald-600 flex items-center justify-center text-white shadow-xl shadow-emerald-500/20">
                <span class="text-2xl font-black">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Configurar Cuenta</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Editando a: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $usuario->email }}</span>
                </p>
            </div>
        </div>
        
        {{-- Acciones Rápidas Superiores --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('usuarios.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 text-xs font-bold uppercase tracking-widest transition-all">
                <i class="fa-solid fa-arrow-left"></i> Regresar
            </a>

            <div class="hidden md:block">
                @if($usuario->is_activo)
                    <span class="px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 text-xs font-bold uppercase tracking-widest">
                        <i class="fa-solid fa-circle-check mr-2"></i> Cuenta Activa
                    </span>
                @else
                    <span class="px-4 py-2 rounded-2xl bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-100 dark:border-rose-500/20 text-xs font-bold uppercase tracking-widest">
                        <i class="fa-solid fa-circle-xmark mr-2"></i> Acceso Restringido
                    </span>
                @endif
            </div>
        </div>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Columna Izquierda: Datos y Estado --}}
            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Credenciales Básicas" desc="Información esencial de contacto y acceso.">
                    <div class="space-y-6">
                        <div>
                            <x-form.input-label for="name" :value="__('Nombre Completo')" required class="font-bold text-slate-700 dark:text-slate-300"/>
                            <x-form.text-input
                                type="text"
                                name="name"
                                id="name"
                                :value="old('name', $usuario->name)"
                                class="w-full mt-1 font-bold"
                            />    
                            <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-form.input-label for="email" :value="__('Correo Electrónico')" required class="font-bold text-slate-700 dark:text-slate-300"/>
                            <x-form.text-input
                                type="email"
                                name="email"
                                id="email"
                                :value="old('email', $usuario->email)"
                                class="w-full mt-1 lowercase font-medium text-slate-600 dark:text-slate-400"
                            />    
                            <x-form.input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <hr class="border-slate-100 dark:border-slate-800">

                        {{-- Toggle is_activo Emerald Style --}}
                        <div class="flex items-center justify-between p-4 rounded-2xl border border-emerald-50 bg-emerald-50/30 dark:border-emerald-500/10 dark:bg-emerald-500/5">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 dark:border-emerald-900/30">
                                    <i class="fa-solid fa-power-off"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-700 dark:text-white">Estado de Acceso</span>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_activo" value="1" class="sr-only peer" {{ old('is_activo', $usuario->is_activo) ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>
                    </div>

                    <x-slot:footer>
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 w-full py-2">
                            <div class="w-full sm:w-auto">
                                @if(checkPermiso('usuarios.is_delete'))
                                    <button 
                                        type="button"
                                        onclick="confirmarEliminacion()"
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-100 dark:border-rose-500/20 text-xs font-bold uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all duration-300"
                                    >
                                        <i class="fa-solid fa-trash-can mr-2"></i> Eliminar Usuario
                                    </button>
                                @endif
                            </div>

                            <div class="w-full sm:w-auto">
                                <x-ui.button size="md" type="submit" form="form-usuarios" class="w-full sm:w-auto shadow-xl shadow-emerald-500/20">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                                </x-ui.button>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            {{-- Columna Derecha: Perfiles Emerald --}}
            <div class="lg:col-span-7">
                <x-common.component-card title="Perfiles de Seguridad" desc="Define los módulos y acciones permitidas para este usuario.">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($perfiles as $perfil)
                            <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border border-slate-100 bg-white hover:bg-emerald-50/50 dark:border-slate-800 dark:bg-white/[0.02] dark:hover:bg-emerald-500/5 transition-all group shadow-sm">
                                <div class="flex items-center h-5">
                                    <input 
                                        type="checkbox" 
                                        name="perfiles[]" 
                                        value="{{ $perfil->id }}" 
                                        {{ $usuario->perfiles->contains($perfil->id) ? 'checked' : '' }}
                                        class="h-6 w-6 rounded-lg border-slate-200 text-emerald-600 focus:ring-4 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-900 transition-all"
                                    >
                                </div>
                                <div class="ml-4">
                                    <span class="block font-extrabold text-sm text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        {{ $perfil->nombre }}
                                    </span>
                                    <span class="block text-[11px] text-slate-400 font-medium uppercase tracking-tighter mt-0.5">
                                        {{ $perfil->descripcion ?: 'Acceso estándar al módulo' }}
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-20 transition-opacity">
                                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </x-common.component-card>
            </div>
        </div>
    </form>
</div>
{{-- Scripts de SweetAlert con colores personalizados --}}
<script>
function confirmarEliminacion() {
    Swal.fire({
        title: '¿Eliminar permanentemente?',
        text: "Esta acción borrará al usuario de la base de datos.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48', // Rose 600
        cancelButtonColor: '#64748b', // Slate 500
        confirmButtonText: 'Sí, eliminar ahora',
        cancelButtonText: 'Cancelar',
        customClass: {
            popup: 'rounded-3xl dark:bg-slate-900 dark:text-white',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-eliminar-usuario').submit();
        }
    });
}
</script>
@endsection