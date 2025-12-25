@extends('layouts.app')

@section('title', 'Analisis')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @livewire('analisis-tabla')

@endsection
