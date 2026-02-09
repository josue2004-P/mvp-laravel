<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
                        'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-slate-950');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-slate-950');
                    }
                }
            });

            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,
                toggleExpanded() { this.isExpanded = !this.isExpanded; this.isMobileOpen = false; },
                toggleMobileOpen() { this.isMobileOpen = !this.isMobileOpen; },
                setMobileOpen(val) { this.isMobileOpen = val; },
                setHovered(val) { if (window.innerWidth >= 1280 && !this.isExpanded) this.isHovered = val; }
            });
        });
    </script>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark', 'bg-slate-950');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark', 'bg-slate-950');
            }
        })();
    </script>
</head>

<body x-data="{ 'loaded': true}" x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
const checkMobile = () => {
    if (window.innerWidth < 1280) {
        $store.sidebar.setMobileOpen(false);
        $store.sidebar.isExpanded = false;
    } else {
        $store.sidebar.isMobileOpen = false;
        $store.sidebar.isExpanded = true;
    }
};
window.addEventListener('resize', checkMobile);">

    <x-common.preloader/>

    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-slate-950">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-slate-950">
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10">
                <x-form.link href="/" class="flex items-center gap-1">
                    <svg class="stroke-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                        <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Volver al inicio
                </x-form.link>
                </div>
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div>
                        <div class="mb-5 sm:mb-8">
                            <x-form.auth-session-status class="mb-4" :status="session('status')" />

                            <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-slate-800 dark:text-white/90">
                                @yield('titleCard') 
                            </h1>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                @yield('descripcionCard') 
                            </p>
                        </div>
                        <div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lado Derecho: Panel Técnico Navy Blue --}}
            <div class="relative hidden h-full w-full items-center lg:grid lg:w-1/2 bg-[#001f3f] dark:bg-[#001f3f]/10 transition-colors duration-300">
                <div class="z-1 flex items-center justify-center">
                    {{-- Forma de rejilla técnica en blanco con baja opacidad --}}
                    <x-common.common-grid-shape class="text-white/5"/>
                    
                    <div class="flex max-w-xs flex-col items-center">
                        {{-- Logo --}}
                        <a href="/" class="mb-6 block transform transition hover:scale-105">
                            {{-- <img src="{{ asset('images/logo/auth-logo.svg') }}" alt="Logo" class="h-16 brightness-0 invert" /> --}}
                        </a>
                        
                        {{-- Línea decorativa técnica --}}
                        <div class="h-[2px] w-12 bg-white/20 rounded-full mb-6"></div>
                        
                        {{-- Texto descriptivo con tracking empresarial --}}
                        <p class="text-center text-[11px] font-black text-white/60 uppercase tracking-[0.4em]">
                            Protocolo de Gestión Integral
                        </p>

                        {{-- Detalle visual de carga/estado --}}
                        <div class="mt-8 flex gap-2">
                            <div class="h-1 w-6 bg-white/10 rounded-full"></div>
                            <div class="h-1 w-12 bg-white/30 rounded-full"></div>
                            <div class="h-1 w-6 bg-white/10 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed right-6 bottom-6 z-50">
                <button
                    class="bg-[#001f3f] hover:bg-slate-800 shadow-xl shadow-[#001f3f]/20 inline-flex size-14 items-center justify-center rounded-xl text-white transition-all active:scale-95 border border-white/10 dark:bg-white dark:text-[#001f3f] dark:hover:bg-slate-200"
                    @click.prevent="$store.theme.toggle()"
                    aria-label="Toggle Theme">
                    
                    {{-- Icono Sol para Modo Oscuro --}}
                    <svg class="hidden stroke-current dark:block" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3V5M12 19V21M4.22 4.22L5.64 5.64M18.36 18.36L19.78 19.78M1 12H3M21 12H23M4.22 19.78L5.64 18.36M18.36 5.64L19.78 4.22M12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    {{-- Icono Luna para Modo Claro --}}
                    <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>

@include('partials.alerts')
@stack('scripts')

</html>