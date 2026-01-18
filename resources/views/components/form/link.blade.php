@props([
    'href' => '#',
])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => "text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400 dark:hover:text-brand-300 transition-colors duration-200"
    ]) }}>
    {{ $slot }}
</a>