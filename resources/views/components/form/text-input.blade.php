@props([
    'disabled' => false,
    'messages' => [],
    'showPassword' => false, 
    'type' => 'text'         
])

<div class="relative">
    <input
        @disabled($disabled)
        
        @if($showPassword)
            x-bind:type="showPassword ? 'text' : 'password'"
        @else
            type="{{ $type }}"
        @endif

        {{ $attributes->merge([
            'class' => "
                dark:bg-slate-900 shadow-theme-xs
                /* Cambiado focus:brand a focus:emerald */
                focus:border-emerald-500 focus:ring-emerald-500/10 dark:focus:border-emerald-400
                h-11 w-full rounded-lg border
                " . ($messages 
                    ? 'border-error-300 text-error-600 focus:border-error-500 focus:ring-error-500/10' 
                    : 'border-gray-300 text-gray-800 dark:border-gray-700 dark:bg-gray-900') . "
                bg-transparent px-4 py-2.5 pr-11 text-sm placeholder:text-gray-400
                focus:ring-3 focus:outline-hidden 
                transition-all duration-200
                dark:text-white/90 dark:placeholder:text-white/30
            "
        ]) }}
    >
    
    @if($showPassword)
        <button 
            type="button"
            @click="showPassword = !showPassword"
            class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
        >
            <x-svg.svg-password-view x-bind:show-password="showPassword"/>
        </button>
    @endif
</div>