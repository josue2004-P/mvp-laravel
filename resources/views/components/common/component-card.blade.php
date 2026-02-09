@props([
    'title',
    'desc' => '',
    'grid' => null, 
    'padding' => 'p-6 sm:p-8',
])

<div
    {{ $attributes->merge([
        'class' => '
            flex flex-col rounded-lg border border-slate-300 dark:border-slate-800 
            bg-white dark:bg-slate-900/50 shadow-sm transition-all duration-300
            
            hover:shadow-md hover:border-slate-300 dark:hover:border-slate-700
        '
    ]) }}
>
    @isset($title)
        <div class="px-6 py-5 border-b border-slate-300 dark:border-slate-800/50">
            {{-- Título con tracking empresarial --}}
            <h3 class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-900 dark:text-white">
                {{ $title }}
            </h3>

            @if($desc)
                {{-- Descripción técnica --}}
                <p class="mt-2 text-[10px] font-bold leading-relaxed uppercase tracking-widest text-slate-400 dark:text-slate-500">
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
        'space-y-6' => !$grid,
    ])>
        {{ $slot }}
    </div>

    @isset($footer)
        {{-- Footer limpio con sutil cambio de fondo --}}
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-black/20 border-t border-slate-300 dark:border-slate-800">
            {{ $footer }}
        </div>
    @endisset
</div>