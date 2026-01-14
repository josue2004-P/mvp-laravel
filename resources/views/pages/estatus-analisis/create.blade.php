@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2>Crear Nuevo Estatus</h2>
    
    <form action="{{ route('estatus-analisis.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" name="descripcion" class="form-control" maxlength="30" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre Corto</label>
            <input type="text" name="nombreCorto" class="form-control" maxlength="10" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Color Texto (Hex)</label>
                <input type="color" name="colorTexto" class="form-control form-control-color" value="#000000">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Color Fondo (Hex)</label>
                <input type="color" name="colorFondo" class="form-control form-control-color" value="#ffffff">
            </div>
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="analsisAbierto" value="1" class="form-check-input" id="abierto">
            <label class="form-check-label" for="abierto">Análisis Abierto</label>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="analisisCerrado" value="1" class="form-check-input" id="cerrado">
            <label class="form-check-label" for="cerrado">Análisis Cerrado</label>
        </div>

        <button type="submit" class="btn btn-success">Guardar Estatus</button>
        <a href="{{ route('estatus-analisis.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection