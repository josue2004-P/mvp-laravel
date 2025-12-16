<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | La Piedad</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<<<<<<< HEAD

    <!-- Alpine.js -->
     <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> 
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js"></script> --}}
=======
     <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> 
>>>>>>> cc532e0e1ba0f5fc80147e2261f6270637ef874a

</head>
<body class="bg-gray-50 font-sans text-gray-800">

    {{-- Encabezado personalizado --}}
    <header x-data="{ open: false }" class="bg-white shadow-md fixed w-full z-20 top-0 left-0">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-indigo-700">La Piedad</a>
        <nav class="hidden md:flex space-x-8 font-medium text-gray-700">
            <a href="#servicios" class="hover:text-cyan-600 transition">Servicios</a>
            <a href="#nosotros" class="hover:text-cyan-600 transition">Nosotros</a>
            <a href="#proceso" class="hover:text-cyan-600 transition">Proceso</a>
            <a href="#contacto" class="hover:text-cyan-600 transition">Contacto</a>
        </nav>
        <button @click="open = !open" class="md:hidden text-gray-700 focus:outline-none">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        </div>
        {{-- Menú responsive --}}
        <div x-show="open" x-transition class="md:hidden bg-white border-t">
        <nav class="px-6 py-4 space-y-2 font-medium text-gray-700">
            <a href="#servicios" class="block hover:text-cyan-600 transition">Servicios</a>
            <a href="#nosotros" class="block hover:text-cyan-600 transition">Nosotros</a>
            <a href="#proceso" class="block hover:text-cyan-600 transition">Proceso</a>
            <a href="#contacto" class="block hover:text-cyan-600 transition">Contacto</a>
        </nav>
        </div>
    </header>

    {{-- preloader --}}
    <x-common.preloader/>
    {{-- preloader end --}}

    {{-- Contenido principal --}}
    <main class="max-w-7xl mx-auto px-4 py-10">
        @yield('content')
    </main>

    {{-- Pie de página --}}
    <footer class="bg-gray-900 text-gray-300 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10">
            
            <!-- Logo y descripción -->
            <div>
            <h3 class="text-2xl font-bold text-white">La Piedad</h3>
            <p class="mt-4 text-sm text-gray-400">Laboratorio especializado en análisis clínicos, de agua y alimentos. Resultados confiables y precisos, avalados por certificaciones.</p>
            </div>

            <!-- Información de contacto -->
            <div>
            <h4 class="text-lg font-semibold text-white mb-4">Contacto</h4>
            <p class="text-gray-400">📍 Av. Siempre Viva 123, Ciudad</p>
            <p class="text-gray-400">📞 (123) 456-7890</p>
            <p class="text-gray-400">✉️ contacto@lapeidad.com</p>
            <p class="text-gray-400 mt-2">🕒 Lunes a Viernes: 8:00 am - 6:00 pm</p>
            </div>

            <!-- Redes sociales -->
            <div>
            <h4 class="text-lg font-semibold text-white mb-4">Síguenos</h4>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-cyan-400 transition">Facebook</a>
                <a href="#" class="hover:text-cyan-400 transition">Instagram</a>
                <a href="#" class="hover:text-cyan-400 transition">LinkedIn</a>
            </div>
            </div>
        </div>

        <!-- Copy -->
        <div class="text-center text-gray-500 text-sm mt-10 border-t border-gray-700 pt-6">
            © {{ date('Y') }} La Piedad. Todos los derechos reservados.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
