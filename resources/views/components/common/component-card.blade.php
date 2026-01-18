@props([
    'title',
    'desc' => '',
    'grid' => null, 
    'padding' => 'p-4 sm:p-6',
])

<div
    {{ $attributes->merge([
        'class' => 'rounded-2xl border border-gray-200 bg-white shadow-sm transition-shadow duration-300 hover:shadow-md dark:border-gray-800 dark:bg-white/[0.03] flex flex-col'
    ]) }}
>
    @isset($title)
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-white/90">
                {{ $title }}
            </h3>

            @if($desc)
                <p class="mt-1.5 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    {{ $desc }}
                </p>
            @endif
        </div>
    @endisset

    <div @class([
        'flex-1',
        $padding,
        'grid' => $grid,
        'gap-6' => $grid,
        'grid-cols-1' => $grid,
        "md:grid-cols-{$grid}" => $grid,
        'space-y-5' => !$grid,
    ])>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-800/20 border-t border-gray-100 dark:border-gray-800 rounded-b-2xl">
            {{ $footer }}
        </div>
    @endisset
</div>