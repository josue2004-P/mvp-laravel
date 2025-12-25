@props([
    'title',
    'desc' => '',
    'grid' => '',
])

<div
    {{ $attributes->merge([
        'class' =>
            'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]'
    ]) }}
>
    <!-- Card Header -->
    @isset($title)
        <div class="px-6 py-5  border-b border-gray-100 dark:border-gray-800 ">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                {{ $title }}
            </h3>

            @if($desc)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $desc }}
                </p>
            @endif
        </div>
    @endisset

    <!-- Card Body -->
    <div class="{{ 'space-y-5  p-4 sm:p-6' . (isset($grid) ? ' gap-2 grid grid-cols-' . $grid : '') }}">
        {{ $slot }}
    </div>

    <!-- Footer (Nuevo Slot Opcional) -->
    @isset($footer)
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 rounded-b-2xl ">
            {{ $footer }}
        </div>
    @endisset

</div>
