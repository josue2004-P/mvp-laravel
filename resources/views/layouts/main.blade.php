<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Gestión MVP') | Sistema de Control</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,900&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> 
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased transition-colors duration-300">

    {{-- Navbar Estilo SaaS --}}
    <header x-data="{ open: false, scrolled: false }" 
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="{ 'bg-white/80 backdrop-blur-lg shadow-sm border-b border-slate-200': scrolled, 'bg-transparent': !scrolled }"
            class="fixed w-full z-50 top-0 left-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            
            <a href="/" class="flex items-center gap-2 group">
                <div class="h-9 w-9 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-600/20 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bolt-lightning text-sm"></i>
                </div>
                <span class="text-xl font-black tracking-tighter text-slate-900">
                    SISTEMA<span class="text-emerald-600">MVP</span>
                </span>
            </a>

            <nav class="hidden md:flex space-x-10 font-bold text-sm uppercase tracking-widest text-slate-500">
                <a href="#modulos" class="hover:text-emerald-600 transition-colors">Módulos</a>
                <a href="#nosotros" class="hover:text-emerald-600 transition-colors">Arquitectura</a>
                <a href="#proceso" class="hover:text-emerald-600 transition-colors">Escalabilidad</a>
                <a href="#contacto" class="px-5 py-2 bg-slate-900 text-white rounded-xl hover:bg-emerald-600 transition-all shadow-lg shadow-slate-900/10">Demo</a>
            </nav>

            <button @click="open = !open" class="md:hidden text-slate-900 focus:outline-none p-2 rounded-lg bg-slate-100">
                <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars-staggered'"></i>
            </button>
        </div>

        {{-- Menú Responsive --}}
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden bg-white border-b border-slate-200 shadow-2xl">
            <nav class="px-6 py-6 space-y-4 font-bold text-slate-600">
                <a href="#modulos" @click="open = false" class="block hover:text-emerald-600 transition-colors">Módulos</a>
                <a href="#nosotros" @click="open = false" class="block hover:text-emerald-600 transition-colors">Arquitectura</a>
                <a href="#proceso" @click="open = false" class="block hover:text-emerald-600 transition-colors">Escalabilidad</a>
                <a href="#contacto" @click="open = false" class="block text-emerald-600">Solicitar Demo</a>
            </nav>
        </div>
    </header>

    {{-- Preloader --}}
    <x-common.preloader/>

    {{-- Contenido Principal --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer Tech Style --}}
    <footer class="bg-slate-900 text-slate-400 py-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-12">
            
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <div class="h-8 w-8 bg-emerald-500 rounded-lg flex items-center justify-center text-slate-900">
                        <i class="fa-solid fa-bolt-lightning text-xs"></i>
                    </div>
                    <span class="text-xl font-black text-white tracking-tighter uppercase">Sistema MVP</span>
                </div>
                <p class="text-sm leading-relaxed max-w-sm">
                    Infraestructura de gestión de alto rendimiento diseñada para la escalabilidad de procesos administrativos y control de seguridad perimetral en aplicaciones web modernas.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-[0.2em] mb-6">Tecnologías</h4>
                <ul class="space-y-3 text-sm font-medium">
                    <li class="flex items-center gap-2"><i class="fa-brands fa-laravel text-emerald-500"></i> Laravel 11 Core</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-wind text-emerald-500"></i> Tailwind CSS</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-code text-emerald-500"></i> Alpine.js Engine</li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-[0.2em] mb-6">Desarrollo</h4>
                <div class="flex space-x-4">
                    <a href="#" class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all">
                        <i class="fa-brands fa-github"></i>
                    </a>
                    <a href="#" class="h-10 w-10 rounded-xl bg-slate-800 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
                <p class="mt-6 text-xs font-bold uppercase tracking-widest text-slate-500">Villahermosa, México</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-bold uppercase tracking-widest">
            <p>© {{ date('Y') }} SISTEMA MVP GESTIÓN. ADAPTACIÓN PROFESIONAL.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-emerald-400 transition-colors">Privacidad</a>
                <a href="#" class="hover:text-emerald-400 transition-colors">Términos</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>