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
                /* Layout Técnico y Color Base #001f3f */
                h-9 w-full rounded-md border text-[10px] font-black uppercase tracking-widest
                transition-all duration-200 focus:outline-hidden focus:ring-0
                bg-slate-50 dark:bg-[#001f3f]/50
                
                /* Lógica de Bordes y Colores de Estado */
                " . ($messages 
                    ? 'border-red-500 text-red-600 focus:border-red-600' 
                    : 'border-[#001f3f]/30 text-slate-950 dark:border-slate-700 dark:text-white focus:border-[#001f3f]') . "
                
                /* Espaciado interno estándar */
                px-4 py-2 placeholder:text-slate-400 dark:placeholder:text-white/20
            "
        ]) }}
    >
    
    @if($showPassword)
        <button 
            type="button"
            @click="showPassword = !showPassword"
            class="absolute top-1/2 right-3 z-30 -translate-y-1/2 cursor-pointer text-slate-400 hover:text-[#001f3f] dark:hover:text-white transition-colors"
        >
            <x-svg.svg-password-view x-bind:show-password="showPassword" class="w-4 h-4"/>
        </button>
    @endif
</div>