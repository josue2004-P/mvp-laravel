@props([
    'disabled' => false,
    'messages' => [],
    'label' => '',
    'name' => '',
    'value' => '1',
    'checked' => false
])

<label {{ $attributes->merge(['class' => 'flex items-center justify-between h-11 w-full rounded-lg border px-4 cursor-pointer ' . 
    ($messages ? 'border-red-300 bg-red-50' : 'border-gray-300 bg-gray-100 dark:bg-gray-800 dark:border-gray-700') 
]) }}>
    
    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
    </span>

    <input 
        type="checkbox" 
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $checked ? 'checked' : '' }}
        @disabled($disabled)
        class="h-5 w-5 rounded border-gray-300 text-brand-600 focus:ring-brand-500/20 dark:bg-gray-900 dark:border-gray-600 checked:bg-brand-600"
    >
</label>