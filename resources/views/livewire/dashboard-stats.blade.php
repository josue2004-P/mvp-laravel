<div>
    <div x-data>
        {{-- Cards --}}
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
                    <h3 class="text-lg font-semibold text-gray-700">Doctores</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $doctores }}</p>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-user-md text-2xl"></i>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Análisis</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $analisis }}</p>
                </div>
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fas fa-vials text-2xl"></i>
                </div>
            </div>

            {{-- NUEVO: Tipos de Análisis --}}
            <div class="bg-white shadow-md rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Tipos de Análisis</h3>
                    <p class="text-3xl font-bold text-orange-600">{{ $tiposAnalisis }}</p>
                </div>
                <div class="bg-orange-100 text-orange-600 p-3 rounded-full">
                    <i class="fas fa-flask text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Gráficas con Alpine + Chart.js --}}
        <div class="flex gap-6 mb-8">
            <div class="w-[29rem] h-[19rem]  bg-white shadow-md rounded-2xl p-6"
                x-data
                x-init="
                    new Chart($refs.clientesChart, {
                        type: 'line',
                        data: {
                            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul','Agos','Sep','Oct'],
                            datasets: [{
                                label: 'Clientes',
                                data: {{ json_encode($clientesPorMes) }},
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.3)',
                                fill: true,
                                tension: 0.3
                            }]
                        }
                    })
                ">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Clientes por Mes</h3>
                <canvas  x-ref="clientesChart"></canvas>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-6 w-[23rem] "
                x-data
                x-init="
                    new Chart($refs.analisisChart, {
                        type: 'doughnut',
                        data: {
                            labels: {{ json_encode(array_keys($analisisCategorias)) }},
                            datasets: [{
                                label: 'Análisis',
                                data: {{ json_encode(array_values($analisisCategorias)) }},
                                backgroundColor: [
                                    '#8b5cf6',
                                    '#10b981',
                                    '#f59e0b',
                                    '#ef4444'
                                ]
                            }]
                        }
                    })
                ">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Análisis por Categoría</h3>
                <canvas x-ref="analisisChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Font Awesome & Chart.js --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>
