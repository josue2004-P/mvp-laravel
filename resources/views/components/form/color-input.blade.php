@props([
    'disabled' => false,
    'messages' => [],
    'color' => '#000000'
])

<div 
    x-data="{ hex: '{{ old($attributes->get('name'), $color) }}' }" 
    class="relative w-full"
>
    <input 
        x-model="hex"
        {{ $attributes->merge([
            'class' => "h-11 w-full rounded-lg border uppercase focus:ring-3 focus:outline-hidden transition-colors bg-transparent px-4 py-2.5 pr-12 text-sm placeholder:text-gray-400 dark:bg-dark-900 shadow-theme-xs " . 
            ($messages ? 'border-red-300 text-error-600' : 'border-gray-300 text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90')
        ]) }}
        @disabled($disabled)
        type="text"
    >
    
    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
        <label class="cursor-pointer">
            <div 
                class="h-6 w-6 rounded border border-gray-300 dark:border-gray-600 shadow-sm" 
                :style="`background-color: ${hex}`"
            ></div>
            <input 
                type="color" 
                x-model="hex" 
                class="sr-only"
                @disabled($disabled)
            >
        </label>
    </div>
</div>