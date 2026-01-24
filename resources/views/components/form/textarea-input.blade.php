@props([
    'disabled' => false,
    'messages' => []
])

<div class="relative">
    <textarea
        @disabled($disabled)
        {{ $attributes->merge([
            'class' => "
                /* Reset y Layout */
                block w-full text-sm p-3 rounded-lg border transition duration-200
                
                /* Colores de TEXTO (Solución al BUG) */
                text-gray-800 dark:text-white
                placeholder:text-gray-400 dark:placeholder:text-white/30
                
                /* Fondo y Bordes (Estado Normal) */
                bg-white dark:bg-gray-900
                " . ($messages 
                    ? 'border-red-500 text-red-600 focus:border-red-500 focus:ring-red-500/20' 
                    : 'border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500/20') . "
                
                /* Estado Deshabilitado */
                disabled:opacity-50 disabled:bg-gray-50 dark:disabled:bg-gray-800
            "
        ]) }}
    >{{ $slot }}</textarea>

    {{-- Errores --}}
    @if($messages)
        <div class="mt-1">
            @foreach ((array) $messages as $message)
                <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
            @endforeach
        </div>
    @endif
</div>