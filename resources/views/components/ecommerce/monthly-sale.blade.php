<div
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-slate-800 dark:bg-white/[0.03] transition-colors duration-300">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white/90">
                Ingresos Mensuales
            </h3>
            <p class="mt-1 text-theme-sm text-slate-500 dark:text-slate-400">
                Comparativa de ingresos brutos vs. margen neto
            </p>
        </div>

        <x-common.dropdown-menu />
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div id="chartOne" class="-ml-5 h-full min-w-[690px] pl-2 xl:min-w-full"></div>
    </div>

    <div class="flex items-center gap-6 border-t border-slate-100 py-4 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <span class="block h-3 w-3 rounded-full bg-emerald-500"></span>
            <span class="text-theme-xs font-medium text-slate-500 dark:text-slate-400">Ingresos Totales</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="block h-3 w-3 rounded-full bg-teal-400"></span>
            <span class="text-theme-xs font-medium text-slate-500 dark:text-slate-400">Margen Neto</span>
        </div>
    </div>
</div>