@props([
    'options' => [], // Las especialidades que vienen del server
    'selected' => [], // Los IDs ya seleccionados (old o base de datos)
    'name' => ''
])

<div x-data="tagComponent({ 
    availableOptions: {{ json_encode($options) }}, 
    initialSelected: {{ json_encode($selected) }} 
})" 
class="relative w-full">
    
    <template x-for="id in selectedIds" :key="id">
        <input type="hidden" name="{{ $name }}[]" :value="id">
    </template>

    <div class="min-h-11 w-full rounded-lg border border-gray-300 bg-transparent px-2 py-1.5 dark:border-gray-700 dark:bg-gray-900 focus-within:ring-3 focus-within:ring-brand-500/10 focus-within:border-brand-300 transition-all flex flex-wrap gap-2 items-center cursor-pointer"
         @click="$refs.menu.focus()">
        
        <template x-for="id in selectedIds" :key="id">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-400 text-sm font-medium border border-brand-200 dark:border-brand-500/20">
                <span x-text="getLabel(id)"></span>
                <button type="button" @click.stop="toggle(id)" class="hover:text-brand-900 dark:hover:text-brand-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </span>
        </template>

        <span x-show="selectedIds.length === 0" class="text-gray-400 text-sm ml-2 select-none">
            Selecciona especialidades...
        </span>

        <input x-ref="menu" readonly @keydown.enter.prevent @keydown.arrow-down.prevent="open = true" 
               class="sr-only" @focus="open = true" @blur="setTimeout(() => open = false, 200)">
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xl max-h-60 overflow-y-auto"
         @click.away="open = false">
        
        <template x-for="option in availableOptions" :key="option.id">
            <div @click="toggle(option.id)" 
                 class="px-4 py-2.5 text-sm cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-center justify-between"
                 :class="selectedIds.includes(option.id) ? 'text-brand-600 dark:text-brand-400 font-semibold bg-brand-50/50 dark:bg-brand-500/5' : 'text-gray-700 dark:text-gray-300'">
                <span x-text="option.nombre"></span>
                <svg x-show="selectedIds.includes(option.id)" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
            </div>
        </template>
    </div>
</div>

<script>
    function tagComponent(data) {
        return {
            open: false,
            availableOptions: data.availableOptions,
            selectedIds: data.initialSelected.map(id => Number(id)),
            
            toggle(id) {
                id = Number(id);
                if (this.selectedIds.includes(id)) {
                    this.selectedIds = this.selectedIds.filter(i => i !== id);
                } else {
                    this.selectedIds.push(id);
                }
            },
            
            getLabel(id) {
                const option = this.availableOptions.find(o => o.id == id);
                return option ? option.nombre : '';
            }
        }
    }
</script>