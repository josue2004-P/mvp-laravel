@props([
    'disabled' => false,
    'messages' => []  // <-- importante para detectar errores
])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => "
            dark:bg-dark-900 shadow-theme-xs
            focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
            h-11 w-full rounded-lg border
            " . ($messages ? 'border-red-300 text-error-600' : 'border-gray-300 text-gray-800 dark:border-gray-700 dark:bg-gray-900') . "
            bg-transparent px-4 py-2.5 pr-10 text-sm placeholder:text-gray-400
            focus:ring-3 focus:outline-hidden 
            dark:text-white/90 dark:placeholder:text-white/30
        "
    ]) }}
>

@if ($messages)
 
@endif
