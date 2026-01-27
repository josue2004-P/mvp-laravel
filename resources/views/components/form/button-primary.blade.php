@props([
    'type' => 'submit',
    'tag' => 'button',
    'full' => false, // Propiedad para decidir si debe ser ancho completo
    'icon' => null,  // Soporte para iconos de FontAwesome
])

<{{ $tag }} 
    {{ $attributes->merge([
        'type' => ($tag === 'button' ? $type : null),
        'class' => ($full ? 'flex w-full' : 'inline-flex') . " items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-900/10 transition duration-200 hover:bg-emerald-700 active:scale-[0.97] disabled:opacity-50 disabled:cursor-not-allowed"
    ]) }}>
    
    {{-- Icono --}}
    @if($icon)
        <i class="fa-solid fa-{{ $icon }} text-base"></i>
    @endif

    {{-- Texto --}}
    <span>{{ $slot }}</span>
</{{ $tag }}>