@extends('layouts.app')

@section('title', 'Historial de Análisis')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Navegación y Título --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="group text-indigo-600 dark:text-indigo-400 text-sm font-semibold flex items-center">
                <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i> 
                Volver al expediente
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Historial Clínico: {{ $cliente->getNombreCompletoAttribute() }}</h1>
        </div>
        
        <div class="flex gap-2">
            <x-ui.button variant="secondary" size="sm">
                <i class="fa-solid fa-download mr-2"></i> Exportar Reporte
            </x-ui.button>
        </div>
    </div>

    {{-- Tabla de Registros --}}
    <x-common.component-card title="Registros Encontrados" desc="Listado cronológico de estudios realizados.">
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">Folio</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Estudio</th>
                        <th class="px-6 py-4">Doctor</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($analisis as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">#{{ $item->id }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="block font-medium text-gray-800 dark:text-gray-200">{{ $item->tipoAnalisis->nombre  }}</span>
                                <span class="text-xs text-gray-500 italic">{{ 'Laboratorio Piedad' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-medium text-gray-800 dark:text-gray-200">{{ $item->doctor->getNombreCompletoAttribute()  }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span 
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm border border-black/5"
                                    style="background-color: {{ $item->estatus->color_fondo }}; color: {{ $item->estatus->color_texto }};"
                                >
                                    <i class="fa-solid fa-circle text-[6px] mr-1.5 opacity-50"></i>
                                    {{ $item->estatus->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-indigo-600 hover:text-indigo-800 font-bold p-2">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fa-solid fa-folder-open text-gray-300 text-4xl mb-3 block"></i>
                                <p class="text-gray-500">No hay análisis registrados aún.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($analisis->hasPages())
            <div class="mt-6 border-t border-gray-100 dark:border-gray-800 pt-4">
                {{ $analisis->links() }}
            </div>
        @endif
    </x-common.component-card>
</div>

{{-- Scripts para las gráficas (TailAdmin usa ApexCharts) --}}
@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Gráfica de Líneas
    const chartOneOptions = {
        series: [{ name: "Glucosa", data: [90, 95, 88, 102, 91, 94] }],
        chart: { type: 'area', height: 250, toolbar: { show: false }, fontFamily: 'Satoshi, sans-serif' },
        stroke: { curve: 'smooth', width: 2 },
        colors: ['#3C50E0'],
        grid: { strokeDashArray: 5, xaxis: { lines: { show: true } } },
        dataLabels: { enabled: false },
    };
    new ApexCharts(document.querySelector("#chartOne"), chartOneOptions).render();

    // Gráfica de Dona
    const chartTwoOptions = {
        series: [44, 15, 25],
        chart: { type: 'donut', width: 340 },
        labels: ['Sangre', 'Orina', 'Rayos X'],
        colors: ['#3C50E0', '#6577F3', '#80CAEE'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '70%' } } }
    };
    new ApexCharts(document.querySelector("#chartTwo"), chartTwoOptions).render();
</script>
@endpush
@endsection