@php
    $banner = "data:image/jpeg;base64," . base64_encode(@file_get_contents(public_path('images/banner.jpeg')));
    $footer = "data:image/jpeg;base64," . base64_encode(@file_get_contents(public_path('images/footer.jpeg')));
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0px; }
        body { font-family: Helvetica, sans-serif; margin: 0; padding: 0; font-size: 11px; color: #333; }
        .footer { position: fixed; bottom: 0; width: 100%; }
        .content { padding: 20px 40px; margin-bottom: 100px; }
        .box-blue { background: #00B0F0; color: white; padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        
        /* Tabla de Resultados del Último */
        .tabla-ultimo { width: 100%; border-collapse: collapse; margin-bottom: 30px; border: 1.5px solid #00B0F0; }
        .tabla-ultimo th { background: #00B0F0; color: white; padding: 10px; text-align: left; }
        .tabla-ultimo td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .val-destacado { color: #00B0F0; font-weight: bold; font-size: 13px; }

        /* Historial */
        .table-historial { width: 100%; border-collapse: collapse; }
        .table-historial th { text-align: left; background: #f8fafc; border-bottom: 2px solid #ccc; padding: 10px; color: #666; }
        .table-historial td { padding: 10px; border-bottom: 1px solid #eee; vertical-align: top; }
        .badge { background: #f1f5f9; padding: 3px 6px; margin: 2px; display: inline-block; border-radius: 4px; font-size: 9px; border: 0.5px solid #cbd5e1; }
    </style>
</head>
<body>
    <div class="header"><img src="{{ $banner }}" style="width:100%"></div>

    <div class="content">
        <div class="box-blue">
            <h2 style="margin:0;">{{ strtoupper($cliente->getNombreCompletoAttribute()) }}</h2>
            <p style="margin:5px 0 0;">EXPEDIENTE DE LABORATORIO | EDAD: {{ $cliente->edad }} AÑOS</p>
        </div>

        {{-- SECCIÓN DINÁMICA DEL ÚLTIMO ANÁLISIS --}}
        <h3 style="color: #00B0F0; border-bottom: 2px solid #00B0F0; padding-bottom: 5px;">
            DETALLE DEL ÚLTIMO ANÁLISIS ({{ $ultimo->created_at->format('d/m/Y h:i:s A') }})
            
        </h3>
        <p style="font-size: 10px; margin-bottom: 5px;">
            <strong>Estudio:</strong> {{ $ultimo->tipoAnalisis->nombre }} | 
            <strong>Médico:</strong> Dr(a). {{ $ultimo->doctor->getNombreCompletoAttribute() ?? 'N/A' }} 
        </p>

        <table class="tabla-ultimo">
            <thead>
                <tr>
                    <th>PARÁMETRO REGISTRADO</th>
                    <th style="text-align: center;">RESULTADO</th>
                    <th style="text-align: center;">UNIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimo->hemogramas as $h)
                    <tr>
                        <td style="font-weight: bold;">{{ $h->nombre }}</td>
                        <td style="text-align: center;" class="val-destacado">
                            {{ $h->pivot->resultado }}
                        </td>
                        <td style="text-align: center; color: #666;">
                            {{ $h->unidad->nombre ?? '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- HISTORIAL SIMPLIFICADO --}}
        <h3 style="margin-top: 20px; color: #333;">HISTORIAL DE ESTUDIOS ANTERIORES</h3>
        <table class="table-historial">
            <thead>
                <tr>
                    <th style="width: 15%;">FECHA</th>
                    <th style="width: 30%;">ESTUDIO</th>
                    <th style="width: 55%;">RESULTADOS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analisisCollection as $item)
                <tr>
                    <td style="font-weight: bold;">{{ $item->created_at->format('d/m/Y h:i:s A') }}</td>
                    <td>
                        <div style="font-weight: bold; color: #00B0F0;">{{ $item->tipoAnalisis->nombre }}</div>
                        <div style="font-size: 9px; color: #999;">ID: #{{ $item->id }}</div>
                    </td>
                    <td>
                        @foreach($item->hemogramas as $h)
                            <div class="badge">
                                <strong>{{ $h->nombre }}:</strong> {{ $h->pivot->resultado }}
                            </div>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>