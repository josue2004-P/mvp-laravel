@extends('layouts.app')

@section('title', 'Editar Usuario')

{{-- Definición de Identidad Técnica --}}
@section('header-icon') <i class="fa-solid fa-user-gear text-xl"></i> @endsection
@section('header-title', 'Editar Perfil')
@section('header-subtitle', 'Modificación de Credenciales y Perfiles de Acceso')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300 pb-20">
    
    {{-- Título Estándar --}}
    <div class="mb-10 flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
        <div class="h-14 w-14 flex-shrink-0 rounded-lg bg-[#001f3f] flex items-center justify-center text-white border border-[#001f3f] shadow-lg shadow-[#001f3f]/10">
            @yield('header-icon')
        </div>
        <div class="w-full">
            <h1 class="text-xl font-black text-slate-950 dark:text-white uppercase tracking-[0.2em]">@yield('header-title')</h1>
            <div class="flex flex-col sm:flex-row items-center gap-2 mt-1">
                <span class="hidden sm:block h-[1px] w-8 bg-[#001f3f]/30"></span>
                <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-microchip text-[9px] text-[#001f3f]/50"></i>
                    Usuario: <span class="font-mono text-[#001f3f] dark:text-blue-400">{{ $usuario->usuario }}</span>
                </p>
            </div>
        </div>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.update', $usuario) }}" method="POST" enctype="multipart/form-data" x-data="imageViewer('{{ asset('storage/'.$usuario->foto) }}', '{{ asset('storage/'.$usuario->firma) }}')">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- SECCIÓN IZQUIERDA: DATOS GENERALES (7/12) --}}
            <div class="lg:col-span-7 space-y-6">
                <x-common.component-card title="Datos Generales" desc="Edición de identidad y validación biométrica.">
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 py-2">
                        {{-- Inputs de Texto --}}
                        <div class="md:col-span-7 space-y-4">
                            <div>
                                <x-form.input-label for="usuario" :value="__('Identificador de Usuario (No Editable)')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest opacity-70"/>
                                <x-form.text-input 
                                    id="usuario" 
                                    type="text" 
                                    name="usuario" 
                                    readonly 
                                    class="w-full mt-1 font-mono !uppercase bg-slate-100 dark:bg-slate-800/50 text-slate-400 cursor-not-allowed border-slate-200 dark:border-slate-700" 
                                    :value="old('usuario', $usuario->usuario)" 
                                />
                                <p class="text-[8px] font-bold text-slate-400 uppercase mt-1 tracking-tighter italic">
                                    * El ID de nodo es inmutable tras su consolidación.
                                </p>
                            </div>
                            <div>
                                <x-form.input-label for="name" :value="__('Nombre(s)')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                <x-form.text-input id="name" type="text" name="name" class="w-full mt-1" :value="old('name', $usuario->name)" required />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-form.input-label for="apellido_paterno" :value="__('Ap. Paterno')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                    <x-form.text-input id="apellido_paterno" type="text" name="apellido_paterno" class="w-full mt-1" :value="old('apellido_paterno', $usuario->apellido_paterno)" required />
                                </div>
                                <div>
                                    <x-form.input-label for="apellido_materno" :value="__('Ap. Materno')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                    <x-form.text-input id="apellido_materno" type="text" name="apellido_materno" class="w-full mt-1" :value="old('apellido_materno', $usuario->apellido_materno)" />
                                </div>
                            </div>
                        </div>

                        {{-- Imagen de Perfil --}}
                        <div class="md:col-span-5 space-y-2 text-center">
                            <x-form.input-label :value="__('Fotografía Actual')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                            <div @click="$refs.fotoInput.click()" class="aspect-square w-full rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-800 flex items-center justify-center overflow-hidden bg-white dark:bg-slate-950/50 cursor-pointer group hover:border-[#001f3f] transition-all relative">
                                <img :src="imageUrl" class="h-full w-full object-cover" x-show="imageUrl">
                                <div x-show="!imageUrl" class="opacity-20"><i class="fa-solid fa-user-circle text-6xl"></i></div>
                                
                                <div class="absolute inset-0 bg-[#001f3f]/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Cambiar Foto</span>
                                </div>
                                <input type="file" x-ref="fotoInput" name="foto" @change="fileChosen" accept="image/*" class="hidden">
                                
                            </div>
                            <x-form.input-error :messages="$errors->get('foto')" class="mt-2" />
                        </div>
                    </div>
                    {{-- Email y Estado --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <x-form.input-label for="email" :value="__('Correo Electrónico')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                            <x-form.text-input id="email" type="email" name="email" class="w-full mt-1 font-mono" :value="old('email', $usuario->email)" required />
                        </div>
                        <div class="flex items-center justify-between p-4 border border-slate-200 dark:border-slate-800 rounded-lg bg-slate-50/50 dark:bg-[#001f3f]/10 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded bg-[#001f3f] dark:bg-blue-600/20 flex items-center justify-center text-white dark:text-blue-400 border border-[#001f3f] dark:border-blue-500/30">
                                    <i class="fa-solid fa-power-off text-[10px]"></i>
                                </div>
                                <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Estatus de Acceso</span>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_activo" value="1" class="sr-only peer" {{ $usuario->is_activo ? 'checked' : '' }}>
                                
                                {{-- Slider del Switch --}}
                                <div class="w-11 h-6 bg-slate-300 dark:bg-slate-700 rounded-full 
                                            peer-checked:bg-[#001f3f] dark:peer-checked:bg-blue-600
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                            after:bg-white dark:after:bg-slate-200 after:rounded-full after:h-5 after:w-5 
                                            after:transition-all peer-checked:after:translate-x-full 
                                            shadow-sm">
                                </div>

                                {{-- Texto de estado dinámico (Opcional pero recomendado para UX técnica) --}}
                                <span class="ml-3 text-[9px] font-black uppercase tracking-tighter text-slate-400 peer-checked:text-[#001f3f] dark:peer-checked:text-blue-400 transition-colors">
                                    <span x-show="!$el.closest('label').querySelector('input').checked">Inactivo</span>
                                    <span x-show="$el.closest('label').querySelector('input').checked">Activo</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- : ACTUALIZACIÓN DE CREDENCIALES (PASSWORD) --}}
                    <div class="pt-6 border-t border-slate-100 dark:border-slate-800 mt-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-key text-[10px] text-[#001f3f] dark:text-blue-400"></i>
                            <h3 class="text-[10px] font-black text-[#001f3f] dark:text-blue-400 uppercase tracking-[0.2em]">Actualización de Credenciales</h3>
                        </div>
                        
                        <div class="p-4 rounded border border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-transparent">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-4">
                                Deje estos campos en blanco si no desea modificar la contraseña actual.
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ showPass: false }">
                                <div>
                                    <x-form.input-label for="password" :value="__('Nueva Clave de Acceso')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                        <div x-data="{ showPassword: false }" class="relative">
                                            <x-form.text-input 
                                                show-password
                                                id="password" type="password" name="password" class="w-full mt-1" placeholder="••••••••"  />
                                        </div>
                                    <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-form.input-label for="password_confirmation" :value="__('Validar Nueva Clave')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                    <div x-data="{ showPassword: false }" class="relative">
                                        <x-form.text-input 
                                            show-password
                                            id="password_confirmation" type="password" name="password_confirmation" class="w-full mt-1" placeholder="••••••••"  />
                                            <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Firma Digital --}}
                    <div class="space-y-3 pt-6 border-t border-slate-100 dark:border-slate-800 mt-6">
                        <x-form.input-label :value="__('Rúbrica Digital Autorizada')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                        <div @click="$refs.firmaInput.click()" class="w-full h-32 rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-800 flex items-center justify-center bg-white dark:bg-slate-950/50 cursor-pointer group hover:border-[#001f3f] transition-all overflow-hidden relative">
                            <img :src="signUrl" class="h-full w-full object-contain p-4 filter dark:invert" x-show="signUrl">
                            <div x-show="!signUrl" class="opacity-20"><span class="text-2xl font-black text-slate-400 uppercase">Sin Firma</span></div>
                            
                            <div class="absolute inset-0 bg-[#001f3f]/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                <span class="text-[10px] font-black text-white uppercase tracking-widest">Actualizar Rúbrica</span>
                            </div>
                            <input type="file" x-ref="firmaInput" name="firma" @change="signChosen" accept="image/*" class="hidden">
                        </div>
                        <x-form.input-error :messages="$errors->get('firma')" class="mt-2" />
                    </div>

                    <x-slot:footer>
                        <div class="flex flex-row items-center justify-between w-full py-2">
                            <x-form.link href="{{ route('usuarios.index') }}" class="group !text-slate-400 hover:!text-rose-600 flex items-center gap-2">
                                <i class="fa-solid fa-chevron-left text-[8px] group-hover:-translate-x-1 transition-transform"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">Descartar Cambios</span>
                            </x-form.link>

                            <div class="flex items-center gap-4">
                                @if(checkPermiso('usuarios.is_delete'))
                                    <button type="button" onclick="confirmarEliminacion()" class="text-[10px] font-black text-rose-500 uppercase tracking-widest hover:text-rose-700">
                                        Eliminar Nodo
                                    </button>
                                @endif
                                <x-ui.button size="md" type="submit" form="form-usuarios" class="w-full">
                                    <i class="fa-solid text-lg fa-floppy-disk mr-2"></i>  Actualizar Registro
                                </x-ui.button>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            {{-- SECCIÓN DERECHA: MATRIZ DE PERFILES (5/12) --}}
            <div class="lg:col-span-5">
                <x-common.component-card title="Perfiles" desc="Asignación de roles y privilegios de seguridad.">
                    <div class="max-h-[600px] overflow-y-auto custom-scrollbar pr-2 space-y-2 py-2">
                        @foreach($perfiles as $perfil)
                            <label class="flex items-center p-3 cursor-pointer rounded border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-transparent hover:border-[#001f3f] transition-all group">
                                <input type="checkbox" name="perfiles[]" value="{{ $perfil->id }}" 
                                    {{ $usuario->perfiles->contains($perfil->id) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-slate-300 text-[#001f3f] focus:ring-[#001f3f]">
                                <div class="ml-3">
                                    <span class="block text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-wider group-hover:text-[#001f3f]">{{ $perfil->nombre }}</span>
                                    <span class="block text-[8px] text-slate-400 font-bold uppercase tracking-widest italic">Activo en este nodo</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </x-common.component-card>
            </div>
        </div>
    </form>
</div>

{{-- Script de previsualización mejorado para edición --}}
<script>
    function imageViewer(initialFoto = '', initialFirma = '') {
        return {
            imageUrl: initialFoto,
            signUrl: initialFirma,
            fileChosen(event) { this.fileToDataUrl(event, src => this.imageUrl = src) },
            signChosen(event) { this.fileToDataUrl(event, src => this.signUrl = src) },
            fileToDataUrl(event, callback) {
                if (! event.target.files.length) return
                let file = event.target.files[0], reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = e => callback(e.target.result)
            }
        }
    }

    function confirmarEliminacion() {
        Swal.fire({
            title: 'Confirmar Purga',
            text: "¿Desea eliminar permanentemente este expediente de usuario?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#001f3f',
            cancelButtonColor: '#e11d48',
            confirmButtonText: 'SÍ, ELIMINAR',
            cancelButtonText: 'ABORTAR',
            customClass: {
                popup: 'rounded-none border-2 border-[#001f3f] dark:bg-slate-950 font-sans',
                title: 'text-sm font-black uppercase tracking-widest dark:text-white'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría tu formulario oculto de eliminación o llamada Livewire/Vite
            }
        });
    }
</script>
@endsection