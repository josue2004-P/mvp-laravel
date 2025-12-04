@extends('layouts.main')

@section('title', 'Contacto | LabQuimic')

@section('content')
  <h2 class="text-3xl font-bold text-center mb-6">Contáctanos</h2>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('contactar') }}" method="POST" class="bg-white shadow-md rounded-lg p-6 space-y-4 max-w-xl mx-auto">
    @csrf

    <div>
      <label for="nombre" class="block text-sm font-medium">Nombre</label>
      <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
             class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      @error('nombre')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="email" class="block text-sm font-medium">Correo electrónico</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required
             class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      @error('email')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="mensaje" class="block text-sm font-medium">Mensaje</label>
      <textarea id="mensaje" name="mensaje" rows="5" required
                class="mt-1 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('mensaje') }}</textarea>
      @error('mensaje')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded">
      Enviar mensaje
    </button>
  </form>
@endsection
