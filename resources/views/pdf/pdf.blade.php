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

    $extraerNum = function($str) {
        if (!$str) return null;
        $limpio = str_replace(',', '', $str);
        preg_match('/[0-9]+(\.[0-9]+)?/', $limpio, $m);
        return isset($m[0]) ? floatval($m[0]) : null;
    };

    $isOutOfRange = function($hemo, $res) use ($extraerNum) {
        $val = $extraerNum($res);
        if ($val === null) return false;
        if ($hemo->rango_ideal || $hemo->rango_alto) {
            $idealLimit = $extraerNum($hemo->rango_ideal);
            $altoLimit = $extraerNum($hemo->rango_alto);
            if ($idealLimit !== null && $val < $idealLimit) return true;
            if ($altoLimit !== null && $val > $altoLimit) return true;
            return false; 
        }
        if ($hemo->referencia) {
            $ref = $hemo->referencia;
            if (strpos($ref, '-') !== false) {
                $parts = explode('-', $ref);
                $min = $extraerNum($parts[0]);
                $max = $extraerNum($parts[1]);
                return ($min !== null && $val < $min) || ($max !== null && $val > $max);
            }
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
            color: #1a1a1a; line-height: 1.3;
        }
        .header, .footer { width: 100%; }
        .footer { position: absolute; bottom: 0; }
        .logo { width: 100%; display: block; }
        .content { padding: 0 35px; margin-top: 10px; }
        
        /* Tabla Paciente - Ahora en 9.5px */
        .tabla-paciente {
            width: 100%; border-collapse: collapse;
            background-color: #00B0F0; color: white; font-size: 9.5px; 
        }
        .tabla-paciente td { padding: 5px 10px; border: 0.5px solid rgba(255,255,255,0.2); }

        /* Título de Sección - Ahora en 14px */
        .titulo-seccion {
            text-align: center; font-size: 14px; font-weight: bold; 
            text-transform: uppercase; margin: 15px 0 8px 0;
            border-bottom: 2px solid #00B0F0; width: 100%;
        }

        /* Método y Muestra - Ahora en 9px */
        .metodo-muestra {
            text-align: center; margin-bottom: 15px; font-size: 9px; 
            color: #475569; text-transform: uppercase;
        }

        /* Tabla Resultados - Ahora en 9.5px */
        .tabla-resultados { width: 100%; border-collapse: collapse; font-size: 9.5px; }
        
        /* Encabezados de Tabla - Ahora en 10px */
        .tabla-resultados th { 
            padding: 6px 4px; 
            border-bottom: 1.5px solid #334155; 
            font-size: 10px;
        }

        /* Categorías - Ahora en 10px */
        .categoria-row td { 
            background-color: #f1f5f9; 
            font-weight: bold; 
            padding: 6px 8px; 
            font-size: 10px; 
        }
        
        .tabla-resultados td { padding: 5px 4px; border-bottom: 0.5px solid #f1f5f9; }
        
        /* Resultados Resaltados - Ahora en 10.5px */
        .texto-negrita { font-weight: 900; font-size: 10.5px; color: #000; }
        .texto-normal { font-weight: normal; font-size: 9.5px; color: #1a1a1a; }
        
        /* Unidades y Referencias - Ahora en 8.5px */
        .unidad-col { color: #64748b; font-size: 8.5px; }
        .rango-txt { display: block; font-size: 8.5px; line-height: 1.1; color: #475569; }
    </style>
</head>
<body>
    <div class="header"><img src="{{ $banner }}" class="logo"></div>

    <div class="content">
        {{-- Datos del Paciente --}}
        <table class="tabla-paciente">
            <tr>
                <td style="width:12%; font-weight: bold;">NOMBRE:</td>
                <td style="width:53%;">{{ Str::upper($analisis->cliente->getNombreCompletoAttribute()) }}</td>
                <td style="width:10%; font-weight: bold;">EDAD:</td>
                <td style="width:25%;">{{ $analisis->cliente->edad }} AÑOS</td>
            </tr>
            <tr>
                <td style="width:12%; font-weight: bold;">MEDICO:</td>
                <td style="width:53%;">{{ Str::upper($analisis->doctor->getNombreCompletoAttribute()) }}</td>
                <td style="width:10%; font-weight: bold;">SEXO:</td>
                <td style="width:25%;">{{ Str::upper($analisis->cliente->sexo) }} </td>
            </tr>
            <tr>
                <td style="width:16%; font-weight: bold;">FECHA TOMA:</td>
                <td style="width:14%;">{{ $analisis->fecha_toma }}</td>
                <td style="width:20%; font-weight: bold;">FECHA REPORTE:</td>
                <td style="width:25%;">{{ $analisis->created_at->format('d/m/Y h:i A') }}</td>
            </tr>
        </table>

        <div class="titulo-seccion">{{ $analisis->tipoAnalisis->nombre }}</div>

        {{-- Método y Muestra --}}
        @if($analisis->tipoMetodo || $analisis->tipoMuestra)
            <div class="metodo-muestra">
                @if($analisis->tipoMetodo)
                    <span style="font-weight: bold; color: #00B0F0;">MÉTODO:</span> {{ $analisis->tipoMetodo->nombre }}
                @endif
                @if($analisis->tipoMetodo && $analisis->tipoMuestra) <span style="margin: 0 10px; color: #cbd5e1;">|</span> @endif
                @if($analisis->tipoMuestra)
                    <span style="font-weight: bold; color: #00B0F0;">MUESTRA:</span> {{ $analisis->tipoMuestra->nombre }}
                @endif
            </div>
        @endif

        <table class="tabla-resultados">
            <thead>
                <tr style="border-bottom: 1.2px solid #334155;">
                    <th style="text-align: left; width: 40%;">ESTUDIO</th>
                    <th style="text-align: center; width: 15%;">RESULTADO</th>
                    <th style="text-align: center; width: 10%;">UNIDAD</th>
                    <th style="text-align: right; width: 35%;">VALORES DE REFERENCIA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analisis->hemogramas->groupBy('categoria.nombre') as $categoria => $hemogramas)
                    <tr class="categoria-row">
                        <td colspan="4" style="background-color: #f1f5f9; font-weight: bold; padding: 4px 8px; font-size: 9.5px;">
                            {{ strtoupper($categoria) }}
                        </td>
                    </tr>
                    @php
                        $grupos = [
                            ['tipo' => null,          'label' => null],
                            ['tipo' => 'diferencial', 'label' => 'DIFERENCIAL ( % )'],
                            ['tipo' => 'absoluto',    'label' => 'ABSOLUTOS']
                        ];
                    @endphp
                    @foreach($grupos as $g)
                        @php $filtrados = $hemogramas->where('tipo_valor', $g['tipo']); @endphp
                        @if($filtrados->count() > 0)
                            @if($g['label'])
                                <tr class="categoria-row">
                                    <td colspan="4" style="background-color: #ffffff; font-weight: bold; padding: 3px 15px; color: #334155; border-bottom: 0.5px solid #dee2e6; font-size: 8.5px;">
                                        {{ $g['label'] }}
                                    </td>
                                </tr>
                            @endif
                            @foreach($filtrados as $hemo)
                                @php 
                                    $resultado = $hemo->pivot->resultado;
                                    $resaltar = $isOutOfRange($hemo, $resultado);
                                @endphp
                                <tr>
                                    <td style="padding-left: {{ $g['tipo'] ? '25px' : '12px' }};">{{ $hemo->nombre }}</td>
                                    <td style="text-align: center;" class="{{ $resaltar ? 'texto-negrita' : 'texto-normal' }}">{{ $resultado }}</td>
                                    <td style="text-align: center;" class="unidad-col">{{ $hemo->unidad->nombre }}</td>
                                    <td style="text-align: right;">
                                        <span class="rango-txt">{{ $hemo->referencia ?? 'N/A' }}</span>
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