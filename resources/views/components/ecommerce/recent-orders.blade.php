@props(['ventas' => []])

@php
    $defaultVentas = [
        [
            'producto' => 'iPhone 15 Pro Max',
            'cliente' => 'Juan Pérez',
            'image' => 'https://via.placeholder.com/50',
            'categoria' => 'Electrónica',
            'total' => '$1,250.00',
            'estado' => 'Completado',
        ],
        [
            'producto' => 'Sudadera Oversize Beige',
            'cliente' => 'María López',
            'image' => 'https://via.placeholder.com/50',
            'categoria' => 'Ropa',
            'total' => '$45.00',
            'estado' => 'Procesando',
        ],
        [
            'producto' => 'Monitor Gaming 27"',
            'cliente' => 'Carlos Gómez',
            'image' => 'https://via.placeholder.com/50',
            'categoria' => 'Computación',
            'total' => '$320.00',
            'estado' => 'Completado',
        ],
        [
            'producto' => 'Cafetera Espresso',
            'cliente' => 'Ana Martínez',
            'image' => 'https://via.placeholder.com/50',
            'categoria' => 'Hogar',
            'total' => '$150.00',
            'estado' => 'Cancelado',
        ],
        [
            'producto' => 'Teclado Mecánico RGB',
            'cliente' => 'Luis Hernández',
            'image' => 'https://via.placeholder.com/50',
            'categoria' => 'Accesorios',
            'total' => '$85.00',
            'estado' => 'Completado',
        ],
    ];

    $ventasList = !empty($ventas) ? $ventas : $defaultVentas;

    $getStatusClasses = function ($estado) {
        $base = 'rounded-full px-2 py-0.5 text-theme-xs font-medium';

        return match ($estado) {
            'Completado' =>
                $base . ' bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
            'Procesando' =>
                $base . ' bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400',
            'Cancelado' =>
                $base . ' bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
            default =>
                $base . ' bg-gray-50 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400',
        };
    };
@endphp

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">

    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Ventas Recientes
            </h3>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                Resumen de las últimas transacciones realizadas
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                Filtrar
            </button>

            <button
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                Ver historial
            </button>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <thead>
                <tr class="border-t border-gray-100 dark:border-gray-800">
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Producto / Cliente
                        </p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Categoría
                        </p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Total
                        </p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                            Estado
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($ventasList as $item)
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td class="py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-[50px] w-[50px] overflow-hidden rounded-md bg-gray-100">
                                    <img
                                        src="{{ $item['image'] }}"
                                        alt="{{ $item['producto'] }}"
                                        class="h-full w-full object-cover">
                                </div>
                                <div>
                                    <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $item['producto'] }}
                                    </p>
                                    <span class="text-theme-xs text-gray-500 dark:text-gray-400">
                                        Comprador: {{ $item['cliente'] }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 whitespace-nowrap">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                {{ $item['categoria'] }}
                            </p>
                        </td>

                        <td class="py-3 whitespace-nowrap">
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $item['total'] }}
                            </p>
                        </td>

                        <td class="py-3 whitespace-nowrap">
                            <span class="{{ $getStatusClasses($item['estado']) }}">
                                {{ $item['estado'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>