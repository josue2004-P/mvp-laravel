@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('header-icon') <i class="fa-solid fa-user-plus text-xl"></i> @endsection
@section('header-title', 'Crear Usuario')
@section('header-subtitle', 'Protocolo de Autenticación y Perfilamiento')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-colors duration-300 pb-20">
    
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
                    @yield('header-subtitle')
                </p>
            </div>
        </div>
    </div>

    <form id="form-usuarios" action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data" x-data="imageViewer()">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-7 space-y-6">
                <x-common.component-card title="Datos Generales" desc="Información de identidad y credenciales de acceso.">
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 py-2">
                        {{-- Inputs de Texto --}}
                        <div class="md:col-span-7 space-y-4">
                            <div>
                                <x-form.input-label for="usuario" :value="__('Usuario')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                <x-form.text-input id="usuario" type="text" name="usuario" class="w-full mt-1 font-mono !uppercase bg-slate-50" :value="old('usuario')" required />
                                <x-form.input-error :messages="$errors->get('usuario')" class="mt-2" />
                            </div>
                            <div>
                                <x-form.input-label for="name" :value="__('Nombre(s)')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                <x-form.text-input id="name" type="text" name="name" class="w-full mt-1" :value="old('name')" required />
                                <x-form.input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-form.input-label for="apellido_paterno" :value="__('Apellido Paterno')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                <x-form.text-input id="apellido_paterno" type="text" name="apellido_paterno" class="w-full mt-1" :value="old('apellido_paterno')" required />
                                <x-form.input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                            </div>
                            <div>
                                <x-form.input-label for="apellido_materno" :value="__('Apellido Materno')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                                <x-form.text-input id="apellido_materno" type="text" name="apellido_materno" class="w-full mt-1" :value="old('apellido_materno')" />
                                <x-form.input-error :messages="$errors->get('apellido_materno')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Imagen de Perfil --}}
                        <div class="md:col-span-5 space-y-2">
                            <x-form.input-label :value="__('Fotografía')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-center md:text-left"/>
                            <div @click="$refs.fotoInput.click()" class="aspect-square w-full rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-800 flex items-center justify-center overflow-hidden bg-white dark:bg-slate-950/50 cursor-pointer group hover:border-[#001f3f] transition-all relative">
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!imageUrl">
                                    <div class="text-center opacity-20 group-hover:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-user-circle text-6xl text-slate-400"></i>
                                    </div>
                                </template>
                                <div class="absolute inset-0 bg-[#001f3f]/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all">
                                    <i class="fa-solid fa-camera text-white text-xl"></i>
                                </div>
                                <input type="file" x-ref="fotoInput" name="foto" @change="fileChosen" accept="image/*" class="hidden">
                            </div>
                            <p class="text-[8px] font-bold text-slate-400 text-center uppercase tracking-tighter italic">Presione para cambiar (500x500px)</p>
                        </div>
                    </div>

                    {{-- Email y Contraseña --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                        <div class="col-span-2">
                            <x-form.input-label for="email" :value="__('Correo Electrónico')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                            <x-form.text-input id="email" type="email" name="email" class="w-full mt-1 font-mono" placeholder="correo@ejemplo.com" required />
                        </div>
                        <div>
                            <x-form.input-label for="password" :value="__('Contraseña')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                            <div x-data="{ showPassword: false }" class="relative">
                                <x-form.text-input 
                                    show-password
                                    id="password" type="password" name="password" class="w-full mt-1" placeholder="••••••••" required />
                                    <x-form.input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-form.input-label for="password_confirmation" :value="__('Confirma Contraseña')" required class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                            <div x-data="{ showPassword: false }" class="relative">
                                <x-form.text-input 
                                    show-password
                                    id="password_confirmation" type="password" name="password_confirmation" class="w-full mt-1" placeholder="••••••••" required />
                                    <x-form.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- Sección de Firma --}}
                    <div class="space-y-3 pt-6 border-t border-slate-100 dark:border-slate-800 mt-6">
                        <div class="flex justify-between items-end">
                            <x-form.input-label :value="__('Firma Digital')" class="text-[10px] font-black text-slate-500 uppercase tracking-widest"/>
                        </div>
                        <div @click="$refs.firmaInput.click()" class="w-full h-32 rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-800 flex items-center justify-center bg-white dark:bg-slate-950/50 cursor-pointer group hover:border-[#001f3f] transition-all overflow-hidden relative">
                            <template x-if="signUrl">
                                <img :src="signUrl" class="h-full w-full object-contain p-4 filter dark:invert">
                            </template>
                            <template x-if="!signUrl">
                                <div class="text-center opacity-20 group-hover:opacity-100 transition-opacity">
                                    <span class="text-4xl font-black text-slate-400 uppercase tracking-[0.2em]">Firma</span>
                                </div>
                            </template>
                            <input type="file" x-ref="firmaInput" name="firma" @change="signChosen" accept="image/*" class="hidden">
                        </div>
                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter italic">Presione sobre la firma si desea cambiarla (400 x 100 px)</p>
                    </div>

                    <x-slot:footer>
                        <div class="flex flex-row items-center justify-between w-full py-2 bg-slate-50/50 dark:bg-transparent">
                            <x-form.link 
                                href="{{ route('usuarios.index') }}" 
                                class="group !text-slate-400 hover:!text-rose-600 transition-colors flex items-center gap-2"
                            >
                                <i class="fa-solid fa-chevron-left text-[8px] transition-transform group-hover:-translate-x-1"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">Descartar Cambios</span>
                            </x-form.link>

                            <div class="flex items-center gap-4">
                                <x-ui.button size="MD" type="submit" form="form-usuarios" class="w-full sm:w-auto">
                                    <x-slot:startIcon>
                                        <i class="fa-solid text-lg fa-floppy-disk"></i>
                                    </x-slot:startIcon>
                                    
                                    Guardar Registro
                                </x-ui.button>
                            </div>
                        </div>
                    </x-slot:footer>
                </x-common.component-card>
            </div>

            {{-- SECCIÓN DERECHA: MATRIZ DE PERFILES --}}
            <div class="lg:col-span-5 space-y-6">
                <x-common.component-card title="Perfiles" desc="Jerarquía de roles asignados al nodo de usuario.">
                    <div class="max-h-[600px] overflow-y-auto custom-scrollbar pr-2 space-y-2 py-2">
                        @foreach($perfiles as $perfil)
                            <label class="flex items-center p-3 cursor-pointer rounded border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-transparent hover:border-[#001f3f] transition-all group">
                                <input type="checkbox" name="perfiles[]" value="{{ $perfil->id }}" class="h-4 w-4 rounded border-slate-300 text-[#001f3f] focus:ring-[#001f3f]">
                                <span class="ml-3 text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-wider group-hover:text-[#001f3f]">{{ $perfil->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </x-common.component-card>
            </div>
        </div>
    </form>
</div>

<script>
    function imageViewer() {
        return {
            imageUrl: '',
            signUrl: '',
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
</script>
@endsection