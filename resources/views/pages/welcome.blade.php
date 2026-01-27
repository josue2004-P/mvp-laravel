@extends('layouts.main')

@section('title', 'Sistema de Gestión MVP')

@section('content')

  {{-- Hero - Enfoque Software de Gestión --}}
  <section class="bg-cover bg-center h-[32rem] flex items-center justify-center text-white relative mt-16"
    style="background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2426&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/90 to-emerald-900/80"></div>
    <div class="relative z-10 text-center p-6 max-w-3xl" x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
      <span x-show="show" x-transition.opacity class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-widest uppercase bg-emerald-500 text-white rounded-full">
        Arquitectura MVP Lista
      </span>
      <h1 x-show="show" 
          x-transition:enter="transition ease-out duration-700 transform"
          x-transition:enter-start="opacity-0 translate-y-10"
          x-transition:enter-end="opacity-100 translate-y-0"
          class="text-4xl md:text-6xl font-black tracking-tight leading-tight">
          Gestión de Accesos y <br><span class="text-emerald-400">Control de Usuarios</span>
      </h1>
      <p x-show="show" 
         x-transition:enter="transition ease-out duration-700 transform delay-300"
         x-transition:enter-start="opacity-0 translate-y-6"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mt-6 text-lg md:text-xl text-slate-300 max-w-xl mx-auto">
         Infraestructura escalable con Blade, Tailwind y Alpine.js. Lista para cualquier adaptación comercial o administrativa.
      </p>
      <div class="mt-10 flex flex-wrap justify-center gap-4">
          <a href="#modulos" x-show="show"
             x-transition:enter="transition ease-out duration-700 transform delay-600"
             class="bg-emerald-600 hover:bg-emerald-500 shadow-lg shadow-emerald-900/20 transition-all px-8 py-3.5 rounded-xl font-bold active:scale-95">
             Explorar Módulos
          </a>
          <a href="#contacto" x-show="show"
             x-transition:enter="transition ease-out duration-700 transform delay-600"
             class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/10 transition-all px-8 py-3.5 rounded-xl font-bold">
             Solicitar Demo
          </a>
      </div>
    </div>
  </section>

  {{-- Módulos del Sistema --}}
  <section id="modulos" class="py-20 bg-slate-50 transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900">Capacidades del Sistema</h2>
            <div class="mt-4 h-1.5 w-20 bg-emerald-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
          @foreach ([
            ['nombre' => 'Gestión de Usuarios', 'descripcion' => 'Control total de cuentas, perfiles de identidad y estados de acceso.', 'icon' => 'fa-users', 'color' => 'emerald'],
            ['nombre' => 'Matriz de Permisos', 'descripcion' => 'Configuración granular de capacidades (Leer, Crear, Editar, Eliminar) por módulo.', 'icon' => 'fa-shield-halved', 'color' => 'emerald'],
            ['nombre' => 'Diccionario de Seguridad', 'descripcion' => 'Registro técnico de llaves de acceso para integración con Middlewares.', 'icon' => 'fa-key', 'color' => 'emerald'],
          ] as $modulo)
            <div x-data="{ hover: false }" 
                 @mouseenter="hover = true" 
                 @mouseleave="hover = false"
                 class="group bg-white rounded-3xl p-8 border border-slate-200 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-900/10">
              <div class="h-14 w-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                <i class="fa-solid {{ $modulo['icon'] }} text-2xl"></i>
              </div>
              <h3 class="text-xl font-bold text-slate-800 mb-3">{{ $modulo['nombre'] }}</h3>
              <p class="text-slate-500 leading-relaxed">{{ $modulo['descripcion'] }}</p>
              <div class="mt-6 pt-6 border-t border-slate-50 flex items-center text-emerald-600 font-bold text-sm">
                Arquitectura MVP <i class="fa-solid fa-check-circle ml-2"></i>
              </div>
            </div>
          @endforeach
        </div>
    </div>
  </section>

  {{-- Tech Stack --}}
  <section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="absolute -top-4 -left-4 w-24 h-24 bg-emerald-100 rounded-full blur-3xl opacity-60"></div>
        <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">Tecnología de Alto Nivel para tu Próximo <span class="text-emerald-600">Proyecto Escalamiento</span></h2>
        <p class="mt-6 text-slate-600 text-lg leading-relaxed">Este MVP ha sido diseñado bajo los estándares de desarrollo moderno, permitiendo una adaptación rápida a cualquier modelo de negocio.</p>
        
        <ul class="mt-8 space-y-4">
            <li class="flex items-center gap-3 font-semibold text-slate-700">
                <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-check text-[10px]"></i></div>
                Laravel 11 + Blade Components
            </li>
            <li class="flex items-center gap-3 font-semibold text-slate-700">
                <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-check text-[10px]"></i></div>
                Tailwind CSS (Emerald/Slate Palette)
            </li>
            <li class="flex items-center gap-3 font-semibold text-slate-700">
                <div class="h-6 w-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center"><i class="fa-solid fa-check text-[10px]"></i></div>
                Interacción Dinámica con Alpine.js
            </li>
        </ul>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 text-center">
            <span class="block text-4xl font-black text-emerald-600 mb-2">100%</span>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Adaptable</span>
        </div>
        <div class="bg-slate-900 p-8 rounded-3xl text-center">
            <span class="block text-4xl font-black text-emerald-400 mb-2">MVP</span>
            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Listo</span>
        </div>
        <div class="col-span-2 bg-emerald-600 p-8 rounded-3xl text-white text-center shadow-xl shadow-emerald-900/20">
            <i class="fa-solid fa-bolt text-3xl mb-4"></i>
            <p class="font-bold">Optimizado para Rendimiento</p>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA Contacto --}}
  <section id="contacto" class="py-24 bg-slate-900 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl -mr-48 -mt-48"></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black text-white mb-4">¿Listo para implementar?</h2>
            <p class="text-slate-400 text-lg">Personalicemos este MVP de acuerdo a tus necesidades específicas.</p>
        </div>

        <div x-data="{ enviado: false }" class="max-w-2xl mx-auto bg-white p-10 rounded-[2.5rem] shadow-2xl transition-all">
          <form x-show="!enviado" @submit.prevent="enviado = true" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Nombre Completo</label>
                  <input type="text" required class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all outline-none">
                </div>
                <div>
                  <label class="block text-sm font-bold text-slate-700 mb-2">Correo Corporativo</label>
                  <input type="email" required class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all outline-none">
                </div>
            </div>
            <div>
              <label class="block text-sm font-bold text-slate-700 mb-2">Detalles del Requerimiento</label>
              <textarea rows="4" required class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 transition-all outline-none" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-black text-lg shadow-xl shadow-emerald-900/10 transition-all active:scale-[0.98]">
                Enviar Solicitud
            </button>
          </form>

          <div x-show="enviado" x-transition class="text-center py-10">
            <div class="h-20 w-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-check text-4xl"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-900">¡Recibido con éxito!</h3>
            <p class="text-slate-500 mt-3">Un consultor técnico se pondrá en contacto contigo pronto.</p>
          </div>
        </div>
    </div>
  </section>

@endsection