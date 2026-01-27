<div
    class="rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
    
    <div class="mb-6 flex flex-col gap-5 sm:flex-row sm:justify-between">
        <div class="w-full">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Rendimiento Comercial
            </h3>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                Seguimiento de ventas, conversión y métricas operativas
            </p>
        </div>

        <div class="flex w-full items-start gap-3 sm:justify-end">
            <div x-data="{ selected: 'ventas' }"
                class="inline-flex w-fit items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900">

                @php
                    $options = [
                        ['value' => 'ventas', 'label' => 'Ventas'],
                        ['value' => 'clientes', 'label' => 'Clientes'],
                        ['value' => 'conversion', 'label' => 'Conversión'],
                    ];
                @endphp

                @foreach ($options as $option)
                    <button
                        @click="selected = '{{ $option['value'] }}'"
                        :class="selected === '{{ $option['value'] }}'
                            ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-800 dark:text-white'
                            : 'text-gray-500 dark:text-gray-400'"
                        class="rounded-md px-3 py-2 text-theme-sm font-medium hover:text-gray-900 dark:hover:text-white">
                        {{ $option['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div id="chartThree" class="-ml-4 min-w-[700px] pl-2 xl:min-w-full"></div>
    </div>
</div>