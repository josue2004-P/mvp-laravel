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
        $base = 'rounded-lg px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide border';

        return match ($estado) {
            'Completado' =>
                $base . ' bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
            'Procesando' =>
                $base . ' bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
            'Cancelado' =>
                $base . ' bg-rose-50 text-rose-700 border-rose-100 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20',
            default =>
                $base . ' bg-slate-50 text-slate-600 border-slate-100 dark:bg-slate-500/10 dark:text-slate-400 dark:border-slate-500/20',
        };
    };
@endphp

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white px-4 pb-3 pt-4 dark:border-slate-800 dark:bg-slate-900/50 sm:px-6 transition-colors duration-300">

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                Ventas Recientes
            </h3>
            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">
                Resumen detallado de las transacciones más recientes.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <button
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <i class="fa-solid fa-filter text-xs"></i>
                Filtrar
            </button>

            <button
                class="inline-flex items-center gap-2 rounded-xl border border-transparent bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-emerald-700">
                Ver historial
            </button>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full border-separate border-spacing-0">
            <thead>
                <tr>
                    <th class="border-b border-slate-100 py-4 text-left dark:border-slate-800">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Producto / Cliente
                        </p>
                    </th>
                    <th class="border-b border-slate-100 py-4 text-left dark:border-slate-800">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Categoría
                        </p>
                    </th>
                    <th class="border-b border-slate-100 py-4 text-left dark:border-slate-800">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Total
                        </p>
                    </th>
                    <th class="border-b border-slate-100 py-4 text-left dark:border-slate-800">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            Estado
                        </p>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                @foreach ($ventasList as $item)
                    <tr class="group transition-colors hover:bg-slate-50/50 dark:hover:bg-slate-800/20">
                        <td class="py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 overflow-hidden rounded-xl border border-slate-100 bg-slate-50 dark:border-slate-800 dark:bg-slate-800">
                                    <img
                                        src="{{ $item['image'] }}"
                                        alt="{{ $item['producto'] }}"
                                        class="h-full w-full object-cover transition-transform group-hover:scale-110">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                                        {{ $item['producto'] }}
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $item['cliente'] }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                {{ $item['categoria'] }}
                            </span>
                        </td>

                        <td class="py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-slate-800 dark:text-white">
                                {{ $item['total'] }}
                            </p>
                        </td>

                        <td class="py-4 whitespace-nowrap">
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