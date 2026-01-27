<div>
    <div x-data>
        {{-- Cards de Métricas Generales --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white shadow-md rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Clientes</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $clientes }}</p>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Ventas</h3>
                    <p class="text-3xl font-bold text-emerald-600">{{ $ventas }}</p>
                </div>
                <div class="bg-emerald-100 text-emerald-600 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Ingresos</h3>
                    <p class="text-3xl font-bold text-indigo-600">${{ number_format($ingresos, 2) }}</p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                    <i class="fas fa-hand-holding-dollar text-2xl"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Productos</h3>
                    <p class="text-3xl font-bold text-amber-600">{{ $productos }}</p>
                </div>
                <div class="bg-amber-100 text-amber-600 p-3 rounded-full">
                    <i class="fas fa-boxes-stacked text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Gráficas --}}
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <div class="flex-1 bg-white shadow-md rounded-2xl p-6"
                x-data
                x-init="
                    new Chart($refs.ventasChart, {
                        type: 'line',
                        data: {
                            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul','Ago','Sep','Oct'],
                            datasets: [{
                                label: 'Ventas Realizadas',
                                data: {{ json_encode($ventasPorMes) }},
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    })
                ">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Rendimiento de Ventas</h3>
                <div class="h-64">
                    <canvas x-ref="ventasChart"></canvas>
                </div>
            </div>

            <div class="w-full lg:w-[23rem] bg-white shadow-md rounded-2xl p-6"
                x-data
                x-init="
                    new Chart($refs.categoriasChart, {
                        type: 'doughnut',
                        data: {
                            labels: {{ json_encode(array_keys($ventasPorCategoria)) }},
                            datasets: [{
                                data: {{ json_encode(array_values($ventasPorCategoria)) }},
                                backgroundColor: [
                                    '#6366f1',
                                    '#f59e0b',
                                    '#10b981',
                                    '#ef4444'
                                ]
                            }]
                        }
                    })
                ">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Ventas por Categoría</h3>
                <canvas x-ref="categoriasChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Assets --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>