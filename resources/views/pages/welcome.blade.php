@extends('layouts.main')

@section('title', 'Inicio')

@section('content')

  {{-- Hero --}}
  <section class="bg-cover bg-center h-[28rem] flex items-center justify-center text-white relative mt-16"
    style="background-image: url('/assets/images/lab-banner.jpg');">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/80 to-cyan-700/80"></div>
    <div class="relative z-10 text-center p-6 max-w-2xl" x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
      <h1 x-show="show" 
          x-transition:enter="transition ease-out duration-700 transform"
          x-transition:enter-start="opacity-0 translate-y-10"
          x-transition:enter-end="opacity-100 translate-y-0"
          class="text-4xl md:text-5xl font-bold tracking-wide">
          Análisis Químicos Profesionales
      </h1>
      <p x-show="show" 
         x-transition:enter="transition ease-out duration-700 transform delay-300"
         x-transition:enter-start="opacity-0 translate-y-6"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mt-4 text-lg md:text-xl text-cyan-100">
         Confía en <strong>La Piedad</strong>, nuestro laboratorio certificado, para resultados precisos y confiables
      </p>
      <a href="#servicios" x-show="show"
         x-transition:enter="transition ease-out duration-700 transform delay-600"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         class="mt-6 inline-block bg-cyan-500 hover:bg-cyan-600 transition px-8 py-3 rounded-full font-semibold shadow-lg">
         Ver servicios
      </a>
    </div>
  </section>

  {{-- Servicios --}}
  <section id="servicios" class="py-16 bg-gray-50">
    <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Nuestros Servicios</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-6xl mx-auto px-6">
      @foreach ([
        ['nombre' => 'Análisis Clínico', 'descripcion' => 'Pruebas de laboratorio para diagnóstico médico confiable.', 'img' => 'analisis-clinico.jpg', 'icon' => '🧬'],
        ['nombre' => 'Análisis de Agua', 'descripcion' => 'Evaluación de potabilidad y detección de contaminantes.', 'img' => 'analisis-agua.jpg', 'icon' => '💧'],
        ['nombre' => 'Análisis de Alimentos', 'descripcion' => 'Control de calidad microbiológico y químico en alimentos.', 'img' => 'analisis-alimentos.jpg', 'icon' => '🥼'],
      ] as $servicio)
        <div x-data="{ hover: false }" 
             @mouseenter="hover = true" 
             @mouseleave="hover = false"
             class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col transform transition duration-300"
             :class="{ 'scale-105 shadow-2xl': hover }">
          <img src="/assets/images/{{ $servicio['img'] }}" alt="{{ $servicio['nombre'] }}" class="h-40 w-full object-cover">
          <div class="p-6 flex-1 flex flex-col">
            <div class="text-5xl mb-3">{{ $servicio['icon'] }}</div>
            <h3 class="text-xl font-semibold text-indigo-700 mb-2">{{ $servicio['nombre'] }}</h3>
            <p class="text-gray-600 flex-1">{{ $servicio['descripcion'] }}</p>
            <a href="#contacto" class="mt-4 inline-block text-cyan-600 font-medium hover:text-cyan-800 transition">Más información →</a>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- Nosotros --}}
  <section id="nosotros" class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h2 class="text-3xl font-bold text-indigo-700 mb-4">Sobre Nosotros</h2>
        <p class="text-gray-700 mb-4">En <strong>La Piedad</strong> contamos con más de 15 años de experiencia en análisis químicos, ambientales y clínicos. Nuestro compromiso es ofrecer resultados confiables que ayuden a médicos, empresas y personas a tomar decisiones informadas.</p>
        <p class="text-gray-700">Trabajamos bajo estrictos estándares de calidad y contamos con certificaciones nacionales e internacionales.</p>
      </div>
      <div>
        <img src="/assets/images/laboratorio.jpg" alt="Laboratorio" class="rounded-xl shadow-lg">
      </div>
    </div>
  </section>

  {{-- Proceso --}}
  <section id="proceso" class="py-16 bg-gray-50">
    <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center">Nuestro Proceso</h2>
    <div class="grid md:grid-cols-4 gap-8 max-w-6xl mx-auto px-6 text-center">
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-3">📋</div>
        <h3 class="font-semibold text-lg text-indigo-700">1. Solicitud</h3>
        <p class="text-gray-600">El cliente nos contacta y detalla el tipo de análisis que requiere.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-3">🧪</div>
        <h3 class="font-semibold text-lg text-indigo-700">2. Muestra</h3>
        <p class="text-gray-600">Se toma o recibe la muestra en condiciones seguras y controladas.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-3">🔬</div>
        <h3 class="font-semibold text-lg text-indigo-700">3. Análisis</h3>
        <p class="text-gray-600">Nuestro equipo realiza pruebas con equipos de última tecnología.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="text-4xl mb-3">📊</div>
        <h3 class="font-semibold text-lg text-indigo-700">4. Resultados</h3>
        <p class="text-gray-600">Se entregan reportes claros, validados y confidenciales.</p>
      </div>
    </div>
  </section>

  {{-- CTA + Formulario de contacto --}}
  <section id="contacto" class="py-16 bg-gradient-to-r from-cyan-700 to-indigo-800 text-white text-center px-4">
    <h2 class="text-3xl font-bold mb-4">¿Necesitas un análisis de laboratorio?</h2>
    <p class="mb-6 text-lg text-cyan-100">Contáctanos y recibe asesoría de nuestros expertos de <strong>La Piedad</strong></p>

    {{-- Formulario con Alpine --}}
    <div x-data="{ nombre: '', email: '', mensaje: '', enviado: false }" class=" max-w-xl mx-auto text-left bg-white text-gray-800 p-8 rounded-xl shadow-lg">
      <form x-show="!enviado" @submit.prevent="enviado = true">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nombre</label>
          <input type="text" x-model="nombre" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
          <input type="email" x-model="email" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Mensaje</label>
          <textarea x-model="mensaje" rows="4" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"></textarea>
        </div>
        <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-md font-medium">Enviar</button>
      </form>

      <div x-show="enviado" x-transition class="text-center py-8">
        <h3 class="text-xl font-semibold text-green-600">✅ ¡Mensaje enviado!</h3>
        <p class="text-gray-700 mt-2">Nos pondremos en contacto contigo lo antes posible.</p>
      </div>
    </div>
  </section>
@endsection
