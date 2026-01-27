<div
    class="rounded-2xl border border-slate-200 bg-white px-5 pb-5 pt-5 dark:border-slate-800 dark:bg-slate-900/50 sm:px-6 sm:pt-6 transition-colors duration-300">
    
    <div class="mb-6 flex flex-col gap-5 sm:flex-row sm:justify-between">
        <div class="w-full">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                Rendimiento Comercial
            </h3>
            <p class="mt-1 text-theme-sm text-slate-500 dark:text-slate-400">
                Seguimiento de ventas, conversión y métricas operativas
            </p>
        </div>

        <div class="flex w-full items-start gap-3 sm:justify-end">
            <div x-data="{ selected: 'ventas' }"
                class="inline-flex w-fit items-center gap-1 rounded-xl bg-slate-100 p-1 dark:bg-slate-800">

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
                            ? 'bg-white text-emerald-600 shadow-sm border border-slate-200/50 dark:bg-slate-700 dark:text-emerald-400 dark:border-slate-600'
                            : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition-all duration-200">
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