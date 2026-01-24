@php
    // Carga de recursos base64
    $pathBanner = public_path('images/banner.jpeg');
    $typeBanner = pathinfo($pathBanner, PATHINFO_EXTENSION);
    $dataBanner = @file_get_contents($pathBanner);
    $banner = $dataBanner ? 'data:image/' . $typeBanner . ';base64,' . base64_encode($dataBanner) : '';

    $pathFooter = public_path('images/footer.jpeg');
    $typeFooter = pathinfo($pathFooter, PATHINFO_EXTENSION);
    $dataFooter = @file_get_contents($pathFooter);
    $footer = $dataFooter ? 'data:image/' . $typeFooter . ';base64,' . base64_encode($dataFooter) : '';

@endphp
@php
    /**
     * Limpia y extrae el valor numérico puro.
     * Maneja comas de miles (5,723 -> 5723) y decimales.
     */
    $extraerNum = function($str) {
        if (!$str) return null;
        $limpio = str_replace(',', '', $str);
        preg_match('/[0-9]+(\.[0-9]+)?/', $limpio, $m);
        return isset($m[0]) ? floatval($m[0]) : null;
    };

    /**
     * Lógica Maestra de Colores:
     * - Rojo (#e11d48): Fuera de rango o riesgo alto.
     * - Naranja (#d97706): Riesgo moderado.
     * - Verde (#059669): Estable / Ideal / Dentro de rango.
     */
    $getHexColor = function($hemo, $res) use ($extraerNum) {
        $val = $extraerNum($res);
        if ($val === null) return '#1a1a1a';

        // --- 1. CASO ESCALONADO (Colesterol / Triglicéridos) ---
        // Priorizamos la validación de Ideal -> Moderado -> Alto
        if ($hemo->rango_ideal || $hemo->rango_moderado || $hemo->rango_alto) {
            $alto = $extraerNum($hemo->rango_alto);
            $mod = $extraerNum($hemo->rango_moderado);
            $ideal = $extraerNum($hemo->rango_ideal);

            // Si es mayor al límite alto configurado (ej: > 240)
            if ($alto !== null && $val >= $alto) return '#e11d48';
            // Si está en el rango moderado (ej: 200 - 239)
            if ($mod !== null && $val >= $mod) return '#d97706';
            // Por defecto, si es menor a los riesgos, es ideal
            return '#059669'; 
        }

        // --- 2. CASO REFERENCIA ESTÁNDAR ---
        if ($hemo->referencia) {
            $ref = $hemo->referencia;

            // Caso A: Rango con guion (ej: "1,800 - 7,700")
            if (strpos($ref, '-') !== false) {
                $parts = explode('-', $ref);
                $min = $extraerNum($parts[0]);
                $max = $extraerNum($parts[1]);
                if (($min !== null && $val < $min) || ($max !== null && $val > $max)) {
                    return '#e11d48'; // Fuera de rango
                }
                return '#059669'; // Estable
            }

            // Caso B: Signo Mayor que (ej: "> 50")
            if (strpos($ref, '>') !== false) {
                $refNum = $extraerNum($ref);
                return ($val > $refNum) ? '#059669' : '#e11d48';
            }

            // Caso C: Signo Menor que (ej: "< 200")
            if (strpos($ref, '<') !== false) {
                $refNum = $extraerNum($ref);
                return ($val < $refNum) ? '#059669' : '#e11d48';
            }

            // Caso D: Dato único (ej: "1800") - comparamos cercanía/igualdad
            $refNum = $extraerNum($ref);
            if ($refNum !== null) {
                return ($val == $refNum) ? '#059669' : '#e11d48';
            }
        }

        return '#1a1a1a'; // Negro si no hay contra qué comparar
    };
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis #{{ $analisis->id }}</title>
    <style>
        @page { margin: 0px; }
        body {
            margin: 0; padding: 0; width: 100%;
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a1a1a; line-height: 1.4;
        }
        .header, .footer { width: 100%; }
        .footer { position: absolute; bottom: 0; }
        .logo { width: 100%; display: block; }
        
        .content { padding: 0 35px; margin-top: 10px; }
        
        /* Encabezado Paciente */
        .tabla-paciente {
            width: 100%; border-collapse: collapse;
            background-color: #00B0F0; color: white; font-size: 11px;
        }
        .tabla-paciente td { padding: 5px 12px; }

        .titulo-seccion {
            text-align: center; font-size: 16px; font-weight: bold;
            text-transform: uppercase; margin: 15px 0;
            border-bottom: 2px solid #00B0F0; width: 100%;
        }

        /* Tabla de Resultados */
        .tabla-resultados { width: 100%; border-collapse: collapse; font-size: 11px; }
        .categoria-row { background-color: #f8fafc; font-weight: bold; font-size: 12px; border-bottom: 1px solid #e2e8f0; }
        .tipo-valor-row { background-color: #f1f5f9; font-size: 10px; font-weight: 800; color: #64748b; }
        
        .tabla-resultados td, .tabla-resultados th { padding: 8px; border-bottom: 0.5px solid #f1f5f9; }
        .res-bold { font-size: 14px; font-weight: bold; }
        .unidad-col { color: #475569; font-weight: bold; font-size: 10px; }
        .rango-txt { display: block; font-size: 9px; line-height: 1.1; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $banner }}" class="logo">
    </div>

    <div class="content">
        {{-- Datos de Cabecera --}}
        <table class="tabla-paciente">
            <tr>
                <td style="width:12%; font-weight: bold;">NOMBRE:</td>
                <td style="width:53%;">{{ $analisis->cliente->getNombreCompletoAttribute() }}</td>
                <td style="width:10%; font-weight: bold;">EDAD:</td>
                <td style="width:25%;">{{ $analisis->cliente->edad }} AÑOS</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">MÉDICO:</td>
                <td>{{ $analisis->doctor->getNombreCompletoAttribute() }}</td>
                <td style="font-weight: bold;">SEXO:</td>
                <td>{{ $analisis->cliente->sexo }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">FECHA:</td>
                <td>{{ $analisis->created_at->format('d/m/Y H:i') }}</td>
                <td style="font-weight: bold;">ID:</td>
                <td>#{{ $analisis->id }}</td>
            </tr>
        </table>

        <div class="titulo-seccion">
            {{ $analisis->tipoAnalisis->nombre }}
            <div style="font-size: 9px; font-weight: normal; margin-top: 3px;">
                MÉTODO: {{ $analisis->tipoMetodo->nombre ?? 'N/A' }} | MUESTRA: {{ $analisis->tipoMuestra->nombre ?? 'N/A' }}
            </div>
        </div>

<table class="tabla-resultados">
    <thead>
        <tr style="border-bottom: 1.5px solid #334155;">
            <th style="text-align: left; width: 40%;">ESTUDIO</th>
            <th style="text-align: center; width: 15%;">RESULTADO</th>
            <th style="text-align: center; width: 10%;">UNIDAD</th>
            <th style="text-align: right; width: 35%;">VALORES DE REFERENCIA</th>
        </tr>
    </thead>
    <tbody>
        @foreach($analisis->hemogramas->groupBy('categoria.nombre') as $categoria => $hemogramas)
            <tr class="categoria-row">
                <td colspan="4" style="padding: 8px; background-color: #f8fafc; font-weight: bold;">
                    {{ strtoupper($categoria) }}
                </td>
            </tr>

            @foreach($hemogramas->groupBy('tipo_valor') as $tipo => $items)
                @if($tipo)
                    <tr class="tipo-valor-row">
                        <td colspan="4" style="padding: 4px 15px; background-color: #f1f5f9; color: #475569; font-size: 10px;">
                            {{ strtoupper($tipo) }} {{ $tipo == 'diferencial' ? '( % )' : '' }}
                        </td>
                    </tr>
                @endif

                @foreach($items as $hemo)
                    @php 
                        $resultado = $hemo->pivot->resultado;
                        $color = $getHexColor($hemo, $resultado);
                    @endphp
                    <tr>
                        <td style="padding-left: {{ $tipo ? '25px' : '10px' }}; width: 40%;">
                            {{ $hemo->nombre }}
                        </td>
                        <td style="text-align: center; width: 15%; color: {{ $color }}; font-weight: bold; font-size: 13px;">
                            {{ $resultado }}
                        </td>
                        <td style="text-align: center; width: 10%; color: #64748b; font-size: 10px;">
                            {{ $hemo->unidad->nombre }}
                        </td>
                        <td style="text-align: right; width: 35%;">
                            @if($hemo->rango_ideal || $hemo->rango_moderado || $hemo->rango_alto)
                                <span class="rango-txt" style="color: #059669;">Ideal: {{ $hemo->rango_ideal }}</span>
                                <span class="rango-txt" style="color: #d97706;">Mod: {{ $hemo->rango_moderado }}</span>
                                <span class="rango-txt" style="color: #e11d48;">Alto: {{ $hemo->rango_alto }}</span>
                            @else
                                <span style="font-size: 10px; color: #475569;">{{ $hemo->referencia ?? 'N/A' }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>

        @if($analisis->nota)
            <div style="margin-top: 25px; padding: 10px; border-left: 3px solid #00B0F0; background-color: #f8fafc; font-size: 10px;">
                <b style="color: #00B0F0;">OBSERVACIONES:</b><br>
                {{ $analisis->nota }}
            </div>
        @endif
    </div>

    <div class="footer">
        <img src="{{ $footer }}" class="logo">
    </div>
</body>
</html>