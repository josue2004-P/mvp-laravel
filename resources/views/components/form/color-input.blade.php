@props([
    'disabled' => false,
    'messages' => [],
    'color' => '#000000'
])

<div 
    x-data="{ 
        hex: '{{ old($attributes->get('name'), $color) }}' 
    }" 
    class="relative w-full group"
>
    {{-- Input de Texto para ver/editar el Hexadecimal --}}
    <input 
        x-model="hex"
        {{ $attributes->merge([
            'class' => "h-11 w-full rounded-xl border uppercase focus:ring-4 focus:outline-hidden transition-all bg-white px-4 py-2.5 pr-14 text-sm font-mono font-bold shadow-theme-xs " . 
            ($messages ? 'border-red-300 text-red-600 focus:ring-red-500/10' : 'border-gray-200 text-gray-700 focus:ring-indigo-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90')
        ]) }}
        @disabled($disabled)
        type="text"
        placeholder="#000000"
        maxlength="7"
    >
    
    {{-- Contenedor del Selector de Color --}}
    <div class="absolute inset-y-0 right-0 flex items-center pr-2">
        <label class="relative flex items-center justify-center cursor-pointer group-hover:scale-110 transition-transform">
            {{-- Cuadrito de Color Visual --}}
            <div 
                class="h-8 w-8 rounded-lg border border-gray-200 dark:border-gray-600 shadow-inner transition-colors duration-300" 
                :style="`background-color: ${hex}`"
            ></div>
            
            {{-- Input Nativo Oculto --}}
            <input 
                type="color" 
                x-model="hex" 
                class="sr-only"
                @disabled($disabled)
                @input="$dispatch('input', $event.target.value)"
            >
        </label>
    </div>
</div>