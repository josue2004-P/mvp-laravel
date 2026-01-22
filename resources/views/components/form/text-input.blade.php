@props([
    'disabled' => false,
    'messages' => [],
    'showPassword' => false, // Prop para activar la lógica de ver/ocultar
    'type' => 'text'         // Tipo por defecto si no es password
])

<div  class="relative">
    <input
        @disabled($disabled)
        
        @if($showPassword)
            x-bind:type="showPassword ? 'text' : 'password'"
        @else
            type="{{ $type }}"
        @endif

        {{ $attributes->merge([
            'class' => "
                dark:bg-dark-900 shadow-theme-xs
                focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800
                h-11 w-full rounded-lg border
                " . ($messages ? 'border-red-300 text-error-600' : 'border-gray-300 text-gray-800 dark:border-gray-700 dark:bg-gray-900') . "
                bg-transparent px-4 py-2.5 pr-10 text-sm placeholder:text-gray-400
                focus:ring-3 focus:outline-hidden 
                dark:text-white/90 dark:placeholder:text-white/30
            "
        ]) }}
    >
    @if($showPassword)
        <span @click="showPassword = !showPassword"
            class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400">
            <x-svg.svg-password-view showPassword/>
        </span>
    @endif


</div>

