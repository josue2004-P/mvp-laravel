@props([
    'disabled' => false,
    'messages' => [],
    'label' => '',
    'dataModel' => '',
    'id' => '',
])

<div
    class="
        flex h-11 w-full overflow-hidden rounded-lg border
        border-gray-300 dark:border-gray-700
        bg-white dark:bg-gray-900
        shadow-theme-xs
        focus-within:border-brand-300
        dark:focus-within:border-brand-800
        focus-within:ring-3
        focus-within:ring-brand-500/10
        input-group-select2
    "
>
    {{-- Label --}}
    <div
        class="
            flex items-center px-3
            bg-gray-100 dark:bg-gray-800
            border-r border-gray-300 dark:border-gray-700
            text-sm font-medium text-gray-700 dark:text-white/70
            whitespace-nowrap
        "
    >
        {{ $label }}
    </div>

    {{-- Select2 --}}
    <div class="flex-1">
        <select id={{$id}} data-model={{ $dataModel }} class="select2 select2-dynamic w-full">
            {{ $slot }}
        </select>
    </div>
</div>
