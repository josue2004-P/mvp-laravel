<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Análisis</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #1a202c; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Análisis Actual</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Cliente</th>
                <th>Doctor</th>
                <th>Análisis</th>
                <th>Método</th>
                <th>Muestra</th>
                <th>Usuario</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($analisis as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->cliente->nombre ?? 'N/A' }}</td>
                <td>{{ $item->doctor->nombre ?? 'N/A' }}</td>
                <td>{{ $item->tipoAnalisis->nombre ?? 'N/A' }}</td>
                <td>{{ $item->tipoMetodo->nombre ?? 'N/A' }}</td>
                <td>{{ $item->tipoMuestra->nombre ?? 'N/A' }}</td>
                <td>{{ $item->usuarioCreacion->name ?? 'N/A' }}</td>
                <td>{{ $item->nota }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>