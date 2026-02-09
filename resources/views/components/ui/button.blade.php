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
    // Base con tipografía técnica y espaciado formal
    $base = 'inline-flex items-center justify-center font-black uppercase tracking-[0.15em] gap-2 rounded-md transition-all duration-200 active:scale-[0.97]';

    $sizeMap = [
        'sm' => 'px-4 py-2 text-[9px]',
        'md' => 'px-6 py-2.5 text-[10px]',
        'lg' => 'px-8 py-3.5 text-[11px]',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['md'];

    $variantMap = [
        // Principal: Navy Blue Corporativo #001f3f
        'primary' => 'bg-[#001f3f] text-white shadow-lg shadow-[#001f3f]/20 hover:bg-slate-800 dark:bg-white dark:text-[#001f3f] dark:hover:bg-slate-200',
        
        // Secundario: Slate técnico (para reportes o filtros)
        'secondary' => 'bg-slate-600 text-white shadow-sm shadow-slate-900/10 hover:bg-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700',
        
        // Outline: Estilo industrial con bordes finos
        'outline' => 'bg-transparent text-slate-700 border border-slate-300 hover:border-[#001f3f] hover:text-[#001f3f] dark:text-slate-400 dark:border-slate-800 dark:hover:border-slate-600 dark:hover:text-white',

        // Peligro: Rojo técnico (para eliminación)
        'danger' => 'bg-rose-700 text-white hover:bg-rose-800 dark:bg-rose-900/30 dark:text-rose-400 dark:border dark:border-rose-900/50 dark:hover:bg-rose-800/40',
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
    {{-- Icono de Inicio --}}
    @if($startIcon)
        <span class="flex items-center text-[0.9em] opacity-90 transition-transform group-hover:scale-110">
            {!! $startIcon !!}
        </span>
    @endif

    {{-- Texto del Botón --}}
    <span class="relative">
        {{ $slot }}
    </span>

    {{-- Icono de Fin --}}
    @if($endIcon)
        <span class="flex items-center text-[0.9em] opacity-90 transition-transform group-hover:translate-x-0.5">
            {!! $endIcon !!}
        </span>
    @endif
</{{ $tag }}>