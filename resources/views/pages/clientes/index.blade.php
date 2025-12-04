@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    @if (session('success'))
        <div class="bg-green-50 border border-green-400 text-green-800 px-4 py-2 rounded-lg mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @livewire('cliente-tabla')
@endsection

