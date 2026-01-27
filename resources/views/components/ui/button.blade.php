@props([
    'size' => 'md',          
    'variant' => 'primary',
    'startIcon' => null,
    'endIcon' => null,
    'className' => '',
    'disabled' => false,
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center font-bold gap-2 rounded-xl transition-all duration-200 active:scale-[0.97]';

    $sizeMap = [
        'sm' => 'px-4 py-2.5 text-xs',
        'md' => 'px-6 py-3 text-sm',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['md'];

    $variantMap = [
        // Principal: Emerald (Verde Esmeralda)
        'primary' => 'bg-emerald-600 text-white shadow-sm shadow-emerald-900/10 hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600',
        
        // Secundario: Cyan/Teal (Cian para reportes y acciones alternativas)
        'secondary' => 'bg-cyan-600 text-white shadow-sm shadow-cyan-900/10 hover:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-600',
        
        // Outline: Slate (Gris azulado profesional)
        'outline' => 'bg-white text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 hover:text-emerald-600 dark:bg-slate-900 dark:text-slate-400 dark:ring-slate-700 dark:hover:bg-emerald-500/5 dark:hover:text-emerald-400',
    ];

    $variantClass = $variantMap[$variant] ?? $variantMap['primary'];

    $disabledClass = $disabled ? 'cursor-not-allowed opacity-50 pointer-events-none' : '';

    $classes = trim("{$base} {$sizeClass} {$variantClass} {$className} {$disabledClass}");
    
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