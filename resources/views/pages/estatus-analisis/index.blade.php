@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Estatus de Análisis</h2>
        <a href="{{ route('estatus-analisis.create') }}" class="btn btn-primary">Nuevo Estatus</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped border">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Nombre Corto</th>
                <th>Colores (Texto/Fondo)</th>
                <th>Abierto</th>
                <th>Cerrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estatus as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->descripcion }}</td>
                <td><span class="badge" style="color: {{ $item->colorTexto }}; background-color: {{ $item->colorFondo }};">
                    {{ $item->nombreCorto }}
                </span></td>
                <td>{{ $item->colorTexto }} / {{ $item->colorFondo }}</td>
                <td>{{ $item->analsisAbierto ? '✅' : '❌' }}</td>
                <td>{{ $item->analisisCerrado ? '✅' : '❌' }}</td>
                <td>
                    <a href="{{ route('estatus-analisis.edit', $item->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('estatus-analisis.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection