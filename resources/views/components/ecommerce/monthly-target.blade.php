<div class="rounded-2xl border border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-white/[0.03] transition-colors duration-300">
    <div class="shadow-sm rounded-2xl bg-white px-5 pb-11 pt-5 dark:bg-slate-900 sm:px-6 sm:pt-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white/90">
                    Rendimiento de Ventas
                </h3>
                <p class="mt-1 text-theme-sm text-slate-500 dark:text-slate-400">
                    Análisis del volumen transaccional mensual
                </p>
            </div>

            <x-common.dropdown-menu />
        </div>

        <div class="relative max-h-[195px] mt-4">
            {{-- Chart --}}
            <div id="chartTwo" class="h-full"></div>

            <span
                class="absolute left-1/2 top-[85%] -translate-x-1/2 -translate-y-[85%] rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-bold text-emerald-600 border border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 shadow-sm">
                +18.5% en ingresos
            </span>
        </div>

        <p class="mx-auto mt-6 w-full max-w-[380px] text-center text-sm leading-relaxed text-slate-500 dark:text-slate-400">
            El volumen de ventas ha superado el objetivo proyectado. <span class="text-emerald-600 font-medium dark:text-emerald-400">Excelente desempeño comercial.</span>
        </p>
    </div>

    <div class="flex items-center justify-around gap-2 px-6 py-4 sm:py-6">
        <div class="flex flex-col items-center">
            <p class="mb-1.5 text-theme-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Pedidos
            </p>
            <p class="flex items-center gap-1.5 text-xl font-bold text-slate-800 dark:text-white">
                1,240
                <span class="text-emerald-500">
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004V13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5V4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z" fill="currentColor" />
                    </svg>
                </span>
            </p>
        </div>

        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>

        <div class="flex flex-col items-center">
            <p class="mb-1.5 text-theme-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Exitosas
            </p>
            <p class="flex items-center gap-1.5 text-xl font-bold text-slate-800 dark:text-white">
                1,156
                <span class="text-emerald-500">
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004V13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5V4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z" fill="currentColor" />
                    </svg>
                </span>
            </p>
        </div>

        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>

        <div class="flex flex-col items-center">
            <p class="mb-1.5 text-theme-xs font-medium uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Hoy
            </p>
            <p class="flex items-center gap-1.5 text-xl font-bold text-slate-800 dark:text-white">
                48
                <span class="text-emerald-500">
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004V13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5V4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z" fill="currentColor" />
                    </svg>
                </span>
            </p>
        </div>
    </div>
</div>