@props([
    'href' => '#',
])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => "text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-200"
    ]) }}>
    {{ $slot }}
</a>