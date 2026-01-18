@props([
    'type' => 'submit', // Por defecto es submit para formularios
    'tag' => 'button',  // Puede cambiar a 'a' si es un enlace
])

<{{ $tag }} 
    {{ $attributes->merge([
        'type' => ($tag === 'button' ? $type : null),
        'class' => "bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition active:scale-[0.98] disabled:opacity-50"
    ]) }}>
    {{ $slot }}
</{{ $tag }}>