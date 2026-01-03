<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | La Piedad</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css',
    'resources/js/app.js'
     ])

    <script src="https://kit.fontawesome.com/698b0c3ebe.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    :root {
        --s2-bg: #ffffff;
        --s2-border: #d1d5db;
        --s2-text: #1f2937;
        --s2-input-bg: #f9fafb;
        --s2-highlight: #4f46e5;
        --s2-clear-hover: #fee2e2;
        --s2-clear-icon: #ef4444;
    }

    /* TEMA OSCURO - Forzado con .dark */
    .dark {
        --s2-bg: #111827;    /* gray-900 */
        --s2-border: #374151; /* gray-700 */
        --s2-text: #f3f4f6;   /* gray-100 */
        --s2-input-bg: #1f2937; /* gray-800 */
        --s2-highlight: #6366f1; /* indigo-500 */
        --s2-clear-hover: #7f1d1d; /* red-900 */
        --s2-clear-icon: #fca5a5; /* red-300 */
    }

    /* --- Estilo del Input (Seleccionado) --- */
    .select2-container--default .select2-selection--single {
        background-color: var(--s2-bg) !important;
        border: 1px solid var(--s2-border) !important;
        height: 44px !important;
        border-radius: 0.5rem !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.2s ease;
    }

    /* FIX TEXTO: Esto asegura que el texto se vea bien en oscuro */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--s2-text) !important; 
        font-size: 0.875rem !important;
        padding-left: 1rem !important;
        padding-right: 75px !important; 
        line-height: 42px !important;
    }

    /* --- MEJORA DE LA "X" --- */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        position: absolute !important;
        right: 40px !important; 
        top: 50% !important;
        transform: translateY(-50%) !important;
        background-color: var(--s2-input-bg) !important;
        color: var(--s2-text) !important;
        width: 20px !important;
        height: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 50% !important;
        font-size: 11px !important;
        font-weight: bold !important;
        z-index: 10 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__clear:hover {
        background-color: var(--s2-clear-hover) !important;
        color: var(--s2-clear-icon) !important;
    }

    .select2-selection__arrow { display: none !important; }

    /* --- LISTA DESPLEGABLE (DROPDOWN) --- */
    /* Aquí corregimos que la lista no se vea blanca en modo oscuro */
    .select2-dropdown {
        background-color: var(--s2-bg) !important;
        border: 1px solid var(--s2-border) !important;
        border-radius: 0.5rem !important;
        z-index: 9999;
    }

    /* Buscador interno del dropdown */
    .select2-search--dropdown .select2-search__field {
        background-color: var(--s2-input-bg) !important;
        border: 1px solid var(--s2-border) !important;
        color: var(--s2-text) !important;
        border-radius: 0.375rem !important;
    }

    /* Opciones individuales */
    .select2-results__option {
        color: var(--s2-text) !important;
        padding: 8px 16px !important;
        background-color: transparent !important;
    }

    /* Opción seleccionada o con hover en la lista */
    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: var(--s2-highlight) !important;
        color: #ffffff !important;
    }
</style>
<script>
    $(document).ready(function() {
        $('.select2-search').each(function() {
            $(this).select2({
                width: '100%',
                placeholder: "Selecciona una opción",
                allowClear: true,
                dropdownParent: $(this).parent() // Ayuda a posicionar bien el dropdown
            });
        });
    });
</script>

    <!-- Alpine.js -->
    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- Theme Store -->
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
                        body.classList.add('dark', 'bg-gray-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-gray-900');
                    }
                }
            });

            Alpine.store('sidebar', {
                // Initialize based on screen size
                isExpanded: window.innerWidth >= 1280, // true for desktop, false for mobile
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    // When toggling desktop sidebar, ensure mobile menu is closed
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                    // Don't modify isExpanded when toggling mobile menu
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    // Only allow hover effects on desktop when sidebar is collapsed
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Apply dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark', 'bg-gray-900');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark', 'bg-gray-900');
            }
        })();
    </script>

    @if (session('swal'))
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: "{{ session('swal.icon') }}",
                title: "{{ session('swal.title') }}",
                text: "{{ session('swal.text') }}",
                confirmButtonText: 'Aceptar'
            });
        });
        </script>
    @endif
    
    @livewireStyles  
</head>

<body
    x-data="{ 'loaded': true}"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
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

    {{-- preloader --}}
    <x-common.preloader/>
    {{-- preloader end --}}

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            <!-- app header start -->
            @include('layouts.app-header')
            <!-- app header end -->
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @yield('content')
            </div>
        </div>

    </div>

    @livewireScripts 
    @stack('scripts')
</body>
  

</html>