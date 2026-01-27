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
                    <a href="/"
                        class="inline-flex items-center text-sm text-emerald-600 transition-colors hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                        <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Volver al inicio
                    </a>
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

            <div class="bg-emerald-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2 dark:bg-emerald-900/20">
                <div class="z-1 flex items-center justify-center">
                    <x-common.common-grid-shape class="text-emerald-500/10"/>
                    <div class="flex max-w-xs flex-col items-center">
                        <a href="/" class="mb-4 block transform transition hover:scale-105">
                            <img src="{{ asset('images/logo/auth-logo.svg') }}" alt="Logo" class="brightness-0 invert" />
                        </a>
                        <div class="h-1 w-10 bg-emerald-500 rounded-full mb-4"></div>
                        <p class="text-center text-emerald-100/80">
                            MVP Laravel
                        </p>
                    </div>
                </div>
            </div>

            <div class="fixed right-6 bottom-6 z-50">
                <button
                    class="bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-900/20 inline-flex size-14 items-center justify-center rounded-full text-white transition-all active:scale-95"
                    @click.prevent="$store.theme.toggle()">
                    <svg class="hidden fill-current dark:block" width="20" height="20" viewBox="0 0 20 20" fill="none"> 
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 14.5a4.5 4.5 0 100-9 4.5 4.5 0 000 9zM10 1.5v2M10 16.5v2M18.5 10h-2M3.5 10h-2M16.01 3.99l-1.414 1.414M5.404 14.596l-1.414 1.414M16.01 16.01l-1.414-1.414M5.404 5.404l-1.414-1.414" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>

@include('partials.alerts')
@stack('scripts')

</html>