@php
    $pathBanner = public_path('images/banner.jpeg'); // Ruta en tu servidor
    $typeBanner = pathinfo($pathBanner, PATHINFO_EXTENSION);
    $dataBanner = file_get_contents($pathBanner);
    $banner = 'data:image/' . $typeBanner . ';base64,' . base64_encode($dataBanner);

    $pathFooter = public_path('images/footer.jpeg'); // Ruta en tu servidor
    $typeFooter = pathinfo($pathFooter, PATHINFO_EXTENSION);
    $dataFooter = file_get_contents($pathFooter);
    $footer = 'data:image/' . $typeFooter . ';base64,' . base64_encode($dataFooter);

@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis #{{ $analisis->id }}</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 100%;
        }
        .footer{
            width: 100%;
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $banner }}" alt="Logo" class="logo">
    </div>

    {{-- DATOS CLIENTE --}}
    <table style="width:100%; border-collapse: collapse; background-color: #00B0F0; border: none;font-size:13px">
        <tr>
            <td style="padding:5px;font-weight: bold;">NOMBRE:</td>
            <td style="padding:5px;">{{ $analisis->cliente->getNombreCompletoAttribute() }}</td>
            <td style="padding:5px;font-weight: bold;">EDAD:</td>
            <td style="padding:5px;">{{ $analisis->cliente->edad }} años</td>
        </tr>
        <tr>
            <td style="padding:5px;font-weight: bold;">MÉDICO:</td>
            <td style="padding:5px;">{{ $analisis->doctor->getNombreCompletoAttribute() }}</td>
            <td style="padding:5px;font-weight: bold;">SEXO:</td>
            <td style="padding:5px;">{{ $analisis->cliente->sexo }} </td>
        </tr>
        <tr>
            <td style="padding:5px;font-weight: bold;">FECHA DE TOMA:</td>
            <td style="padding:5px;">{{ $analisis->created_at->format('d/m/Y H:i') }}</td>
            <td style="padding:5px;font-weight: bold;">FECHA DE REPORTE:</td>
            <td style="padding:5px;">{{ $analisis->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    {{-- TIPO DE ANALISIS Y MUESTRA--}}
    <div style="width: 100%; text-align: center;">
        <h1 style="padding: 5px; margin: 0; font-size:16px">{{ $analisis->tipoAnalisis->nombre }}</h1>
        @if($analisis->tipoMetodo)
            <p style="margin: 0; font-size:12px">
                METODO: {{ $analisis->tipoMetodo->nombre }}
            </p>
        @endif

        @if($analisis->tipoMuestra)
            <p style="margin: 0; font-size:12px">
                MUESTRA: {{ $analisis->tipoMuestra->nombre }}
            </p>
        @endif
    </div>

    {{-- Tabla de hemogramas --}}
    <table style="width:100%; border-collapse: collapse; margin-top:20px;">
        @foreach($analisis->hemogramas->groupBy('categoria.nombre') as $categoria => $hemogramas)
            {{-- Fila de categoría --}}
            <tr style="background-color:#f0f0f0;">
                <td colspan="1" style="padding:8px; font-weight:bold;">{{ $categoria }}</td>
                <td colspan="1" style="padding:8px; font-weight:bold;">Resultado</td>
                <td colspan="1" style="padding:8px; font-weight:bold;">Unidad</td>
                <td colspan="1" style="padding:8px; font-weight:bold;">Referencia</td>
            </tr>

            {{-- Filas de hemogramas --}}
            @foreach($hemogramas as $hemo)
            <tr>
                <td style="padding:5px; width:50%;">{{ $hemo->nombre }}</td>
                <td style="padding:5px; width:50%;">{{ $hemo->pivot->resultado }}</td>
                <td style="padding:5px; width:25%;">{{ $hemo->unidad->nombre }}</td>
                <td style="padding:5px; width:25%;">{{ $hemo->referencia }}</td>
            </tr>
            @endforeach
        @endforeach
    </table>

    {{-- NOTA --}}
    <table style="background-color:#f0f0f0; width:100%; border-collapse: collapse; margin-top:20px;">
        <tr style="">
            <td style="font-weight:bold; padding:5px; width:10%;">Nota:</td>
            <td style="padding:5px; width:90%;">{{ $analisis->nota }}</td>
        </tr>
    </table>

    <div class="footer">
        <img src="{{ $footer }}" alt="Logo" class="logo">
    </div>
</body>
</html>
