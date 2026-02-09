@props([
    'type' => 'submit',
    'tag' => 'button',
    'full' => false,
    'icon' => null,
])

<{{ $tag }} 
    {{ $attributes->merge([
        'type' => ($tag === 'button' ? $type : null),
        'class' => ($full ? 'flex w-full' : 'inline-flex') . " 
            /* Layout y Tipografía Técnica */
            items-center justify-center gap-2 rounded-md px-5 py-3 
            text-[10px] font-black uppercase tracking-[0.2em] 
            transition-all duration-200 active:scale-[0.98]
            disabled:opacity-50 disabled:cursor-not-allowed
            
            /* Colores modo claro: Navy Blue #001f3f */
            bg-[#001f3f] text-white shadow-lg shadow-[#001f3f]/20
            hover:bg-slate-800 hover:shadow-none
            
            /* Colores modo oscuro: Blanco con texto Navy */
            dark:bg-white dark:text-[#001f3f] dark:shadow-none
            dark:hover:bg-slate-200
        "
    ]) }}>
    
    {{-- Icono --}}
    @if($icon)
        <i class="fa-solid fa-{{ $icon }} text-xs"></i>
    @endif

    {{-- Texto --}}
    <span>{{ $slot }}</span>
</{{ $tag }}>