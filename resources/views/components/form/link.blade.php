@props([
    'href' => '#',
])

<a href="{{ $href }}" 
    {{ $attributes->merge([
        'class' => "
            /* Tipografía Técnica */
            text-[10px] font-black uppercase tracking-widest
            transition-colors duration-200
            
            /* Colores modo claro: Azul Institucional */
            text-[#001f3f] hover:text-slate-700
            
            /* Colores modo oscuro: Azul vibrante para contraste */
            dark:text-blue-400 dark:hover:text-white
        "
    ]) }}>
    {{ $slot }}
</a>