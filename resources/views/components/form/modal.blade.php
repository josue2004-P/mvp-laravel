@props(['name', 'show' => false])

<div
    x-data="{ 
        show: @js($show),
        focusables() {
            let selector = 'a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
            return [...$el.querySelectorAll(selector)].filter(el => ! el.hasAttribute('disabled'));
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="if ($event.detail == '{{ $name }}') show = true"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey ? prevFocusable().focus() : nextFocusable().focus()"
    x-show="show"
    {{-- Posicionamiento absoluto sobre toda la ventana --}}
    class="fixed inset-0 z-[99999] flex flex-col w-screen h-screen"
    style="display: none;"
>
    {{-- Fondo Difuminado (Backdrop) --}}
    <div 
        x-show="show" 
        class="fixed inset-0 transition-opacity duration-300"
        x-transition:enter="ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        {{-- bg-white/40 para claro y bg-black/40 para oscuro con blur fuerte --}}
        <div class="absolute inset-0 bg-white/40 dark:bg-black/40 backdrop-blur-2xl"></div>
    </div>

    {{-- Contenedor del Contenido --}}
    <div 
        x-show="show" 
        class="relative flex flex-col flex-1 w-full h-full transform transition-all overflow-y-auto"
        x-transition:enter="ease-out duration-300" 
        x-transition:enter-start="opacity-0 scale-95" 
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="ease-in duration-200" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-95"
    >
        {{-- Este div centra el contenido del formulario en el medio de la pantalla --}}
        <div class="flex flex-col items-center justify-center min-h-screen p-6">
            <div class="w-full max-w-2xl bg-white dark:bg-[#1f2937] p-8 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>