@props(['countries' => []])

@php
    $defaultCountries = [
        [
            'name' => 'USA',
            'flag' => './images/country/country-01.svg',
            'customers' => '2,379',
            'percentage' => 79
        ],
        [
            'name' => 'France',
            'flag' => './images/country/country-02.svg',
            'customers' => '589',
            'percentage' => 23
        ],
    ];
    
    $countriesList = !empty($countries) ? $countries : $defaultCountries;
@endphp

<div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-white/[0.03] sm:p-6 transition-colors">
    <div class="flex justify-between">
        <div>
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white/90">
                Demografía de Clientes
            </h3>
            <p class="mt-1 text-theme-sm text-slate-500 dark:text-slate-400">
                Distribución de clientes por país
            </p>
        </div>

         <x-common.dropdown-menu />
         </div>

    <div class="my-6 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 px-4 py-6 dark:border-slate-800 dark:bg-slate-900/50 sm:px-6">
        <div id="mapOne" class="mapOne map-btn -mx-4 -my-6 h-[212px] w-[252px] 2xsm:w-[307px] xsm:w-[358px] sm:-mx-6 md:w-[668px] lg:w-[634px] xl:w-[393px] 2xl:w-[554px]"></div>
    </div>

    <div class="space-y-5">
        @foreach($countriesList as $country)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-full max-w-8 items-center rounded-full overflow-hidden border border-slate-100 dark:border-slate-800">
                        <img src="{{ $country['flag'] }}" alt="{{ strtolower($country['name']) }}" class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <p class="text-theme-sm font-semibold text-slate-800 dark:text-white/90">
                            {{ $country['name'] }}
                        </p>
                        <span class="block text-theme-xs text-slate-500 dark:text-slate-400">
                            {{ $country['customers'] }} Clientes
                        </span>
                    </div>
                </div>

                <div class="flex w-full max-w-[140px] items-center gap-3">
                    <div class="relative block h-2.5 w-full max-w-[100px] rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <div 
                            class="absolute left-0 top-0 flex h-full items-center justify-center rounded-full bg-emerald-600 transition-all duration-500"
                            style="width: {{ $country['percentage'] }}%"
                        ></div>
                    </div>
                    <p class="text-theme-sm font-bold text-emerald-700 dark:text-emerald-400">
                        {{ $country['percentage'] }}%
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>