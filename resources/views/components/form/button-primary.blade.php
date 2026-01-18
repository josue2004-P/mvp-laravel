@props([
    'type' => 'submit',
    'tag' => 'button',
    'full' => false, // Propiedad para decidir si debe ser ancho completo
    'icon' => null,  // Soporte para iconos de FontAwesome
])

<{{ $tag }} 
    {{ $attributes->merge([
        'type' => ($tag === 'button' ? $type : null),
        'class' => ($full ? 'flex w-full' : 'inline-flex') . " items-center justify-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-sm font-bold text-white shadow-theme-xs transition duration-200 hover:bg-brand-600 active:scale-[0.96] disabled:opacity-50"
    ]) }}>
    
    {{-- Icono --}}
    @if($icon)
        <i class="fa-solid fa-{{ $icon }} text-sm"></i>
    @endif

    {{-- Texto --}}
    <span>{{ $slot }}</span>
</{{ $tag }}>