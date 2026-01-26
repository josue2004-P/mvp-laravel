@php
    // Carga de recursos base64 (Sin cambios)
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
    $extraerNum = function($str) {
        if (!$str) return null;
        $limpio = str_replace(',', '', $str);
        preg_match('/[0-9]+(\.[0-9]+)?/', $limpio, $m);
        return isset($m[0]) ? floatval($m[0]) : null;
    };

    /**
     * Nueva Lógica:
     * Negrita SI: (valor < ideal) O (valor > alto)
     */
    $isOutOfRange = function($hemo, $res) use ($extraerNum) {
        $val = $extraerNum($res);
        if ($val === null) return false;

        // 1. CASO ESCALONADO (Colesterol, etc.)
        if ($hemo->rango_ideal || $hemo->rango_alto) {
            $idealLimit = $extraerNum($hemo->rango_ideal);
            $altoLimit = $extraerNum($hemo->rango_alto);

            // Negrita si es menor al ideal (ej: < 200)
            if ($idealLimit !== null && $val < $idealLimit) return true;
            
            // Negrita si es mayor al alto (ej: > 240)
            if ($altoLimit !== null && $val > $altoLimit) return true;

            return false; 
        }

        // 2. CASO REFERENCIA ESTÁNDAR (Rangos normales min-max)
        if ($hemo->referencia) {
            $ref = $hemo->referencia;
            if (strpos($ref, '-') !== false) {
                $parts = explode('-', $ref);
                $min = $extraerNum($parts[0]);
                $max = $extraerNum($parts[1]);
                return ($min !== null && $val < $min) || ($max !== null && $val > $max);
            }
            // Casos directos > o <
            if (strpos($ref, '>') !== false) return $val <= $extraerNum($ref);
            if (strpos($ref, '<') !== false) return $val >= $extraerNum($ref);
        }

        return false;
    };
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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

        .tabla-resultados { width: 100%; border-collapse: collapse; font-size: 11px; }
        .categoria-row { background-color: #f8fafc; font-weight: bold; font-size: 12px; border-bottom: 1px solid #e2e8f0; }
        
        .tabla-resultados td, .tabla-resultados th { padding: 8px; border-bottom: 0.5px solid #f1f5f9; }
        
        /* Estilos condicionales */
        .texto-negrita { font-weight: 900; font-size: 13px; color: #000; }
        .texto-normal { font-weight: normal; font-size: 12px; color: #1a1a1a; }
        
        .unidad-col { color: #64748b; font-size: 10px; }
        .rango-txt { display: block; font-size: 9px; line-height: 1.1; color: #475569; }
    </style>
</head>
<body>
    <div class="header"><img src="{{ $banner }}" class="logo"></div>

    <div class="content">
        {{-- Tabla de Paciente --}}
        <table class="tabla-paciente">
            <tr>
                <td style="width:12%; font-weight: bold;">NOMBRE:</td>
                <td style="width:53%;">{{ $analisis->cliente->getNombreCompletoAttribute() }}</td>
                <td style="width:10%; font-weight: bold;">EDAD:</td>
                <td style="width:25%;">{{ $analisis->cliente->edad }} AÑOS</td>
            </tr>
            <tr>
                <td style="width:12%; font-weight: bold;">MEDICO:</td>
                <td style="width:53%;">{{ $analisis->doctor->getNombreCompletoAttribute() }}</td>
                <td style="width:10%; font-weight: bold;">SEXO:</td>
                <td style="width:25%;">{{ $analisis->cliente->sexo }} </td>
            </tr>
            <tr>
                <td style="width:16%; font-weight: bold;">FECHA TOMA:</td>
                <td style="width:14%;">{{ $analisis->fecha_toma }}</td>
                <td style="width:20%; font-weight: bold;">FECHA REPORTE:</td>
                <td style="width:25%;">{{ $analisis->created_at->format('d/m/Y h:i:s A') }}</td>
            </tr>
            {{-- ... resto de filas de cabecera ... --}}
        </table>

        <div class="titulo-seccion">{{ $analisis->tipoAnalisis->nombre }}</div>

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
                {{-- Título Principal: FORMULA ROJA, BLANCA, etc. --}}
                <tr class="categoria-row">
                    <td colspan="4" style="background-color: #f1f5f9; font-weight: bold; padding: 8px;">
                        {{ strtoupper($categoria) }}
                    </td>
                </tr>

                @php
                    // Definimos los grupos según tus datos de MySQL (minúsculas)
                    $grupos = [
                        ['tipo' => null,          'label' => null],
                        ['tipo' => 'diferencial', 'label' => 'DIFERENCIAL ( % )'],
                        ['tipo' => 'absoluto',    'label' => 'ABSOLUTOS']
                    ];
                @endphp

                @foreach($grupos as $g)
                    @php 
                        // Filtramos los hemogramas que correspondan al tipo actual
                        $filtrados = $hemogramas->where('tipo_valor', $g['tipo']); 
                    @endphp

                    @if($filtrados->count() > 0)
                        {{-- Pintamos el subtítulo si existe (Diferencial o Absoluto) --}}
                        @if($g['label'])
                            <tr class="categoria-row">
                                <td colspan="4" style="background-color: #ffffff; font-weight: bold; padding: 6px 15px; color: #334155; border-bottom: 1px solid #dee2e6;">
                                    {{ $g['label'] }}
                                </td>
                            </tr>
                        @endif

                        {{-- Pintamos los estudios de este grupo --}}
                        @foreach($filtrados as $hemo)
                            @php 
                                $resultado = $hemo->pivot->resultado;
                                $resaltar = $isOutOfRange($hemo, $resultado);
                            @endphp
                            <tr>
                                <td style="padding-left: {{ $g['tipo'] ? '30px' : '15px' }};">
                                    {{ $hemo->nombre }}
                                </td>
                                <td style="text-align: center;" class="{{ $resaltar ? 'texto-negrita' : 'texto-normal' }}">
                                    {{ $resultado }}
                                </td>
                                <td style="text-align: center;" class="unidad-col">{{ $hemo->unidad->nombre }}</td>
                                <td style="text-align: right;">
                                    <span style="font-size: 10px; color: #475569;">{{ $hemo->referencia ?? 'N/A' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer"><img src="{{ $footer }}" class="logo"></div>
</body>
</html>