@props([
    'size' => 'md',          
    'variant' => 'primary',
    'startIcon' => null,
    'endIcon' => null,
    'className' => '',
    'disabled' => false,
    'href' => null, // Agregamos la prop href
])

@php
    // Mantenemos tus clases base y mapas exactamente igual
    $base = 'inline-flex items-center justify-center font-medium gap-2 rounded-lg transition';

    $sizeMap = [
        'sm' => 'px-4 py-2 ',
        'md' => 'px-5 py-3.5 text-sm',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['md'];

    $variantMap = [
        'primary' => 'px-4 py-2 bg-blue-600 text-white rounded-lg',
        'secondary' => 'px-4 py-2 bg-indigo-600 text-white rounded-lg', // Añadida para tu reporte
        'outline' => 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03] dark:hover:text-gray-300',
    ];

    $variantClass = $variantMap[$variant] ?? $variantMap['primary'];

    $disabledClass = $disabled ? 'cursor-not-allowed opacity-50 pointer-events-none' : '';

    $classes = trim("{$base} {$sizeClass} {$variantClass} {$className} {$disabledClass}");
    
    // Determinamos la etiqueta
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    {{ $attributes->merge([
        'class' => $classes, 
        'type' => $href ? null : $attributes->get('type', 'button'),
        'href' => $href
    ]) }}
    @if($disabled && !$href) disabled @endif
    @if($disabled && $href) aria-disabled="true" @endif
>
    {{-- Mantenemos tu lógica de iconos intacta --}}
    @hasSection('startIcon')
        <span class="flex items-center">
            @yield('startIcon')
        </span>
    @elseif($startIcon)
        <span class="flex items-center">{!! $startIcon !!}</span>
    @endif

    {{ $slot }}

    @hasSection('endIcon')
        <span class="flex items-center">
            @yield('endIcon')
        </span>
    @elseif($endIcon)
        <span class="flex items-center">{!! $endIcon !!}</span>
    @endif
</{{ $tag }}>