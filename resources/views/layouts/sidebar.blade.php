@php
use App\Helpers\MenuHelper;

$menuGroups = MenuHelper::getMenuGroups();
$currentPath = request()->path();

// Filtrar menú según permisos del usuario
$menuFiltrado = [];

foreach ($menuGroups as $group) {
    $itemsFiltrados = [];

    foreach ($group['items'] as $item) {
        // Verifica permiso del item principal
        if (!isset($item['permiso']) || checkPermiso($item['permiso'])) {

            // Filtrar sub-items según permiso
            if (isset($item['subItems'])) {
                $item['subItems'] = array_values(array_filter($item['subItems'], function($subItem) {
                    return !isset($subItem['permiso']) || checkPermiso($subItem['permiso']);
                }));
            }

            $itemsFiltrados[] = $item;
        }
    }

    if (!empty($itemsFiltrados)) {
        $menuFiltrado[] = [
            'title' => $group['title'],
            'items' => $itemsFiltrados
        ];
    }
}
@endphp

<aside id="sidebar"
    {{-- Sidebar: Blanco en Light / Slate 950 en Dark --}}
    class="fixed flex flex-col mt-0 top-0 px-3 left-0 bg-gray-200 dark:bg-slate-950 h-screen transition-all duration-300 ease-in-out z-99999 border-r border-slate-300 dark:border-slate-800 text-slate-900"
    x-data="{
        openSubmenus: {},
        init() {
            this.initializeActiveMenus();
        },
        initializeActiveMenus() {
            const currentPath = '{{ $currentPath }}';
            @foreach ($menuFiltrado as $groupIndex => $menuGroup)
                @foreach ($menuGroup['items'] as $itemIndex => $item)
                    @if (isset($item['subItems']))
                        @foreach ($item['subItems'] as $subItem)
                            if (currentPath === '{{ ltrim($subItem['path'], '/') }}' ||
                                window.location.pathname === '{{ $subItem['path'] }}') {
                                this.openSubmenus['{{ $groupIndex }}-{{ $itemIndex }}'] = true;
                            }
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        },
        toggleSubmenu(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            if (this.openSubmenus[key]) {
                this.openSubmenus = {};
            } else {
                this.openSubmenus = {};
                this.openSubmenus[key] = true;
            }
        },
        isSubmenuOpen(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            return this.openSubmenus[key] || false;
        },
        isActive(path) {
            return window.location.pathname === path || '{{ $currentPath }}' === path.replace(/^\//, '');
        }
    }"
    :class="{
        'w-[250px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[70px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">

    <div class="flex flex-col transition-all duration-300 pb-6 pt-20 lg:pt-14 xl:pt-3">
        <div class="flex items-center w-full" 
            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'justify-center' : 'justify-start'">
            
            <div class="flex-shrink-0">
                {{-- Avatar: Fondo azul sólido #001f3f siempre --}}
                <img class="h-11 w-11 rounded-full border-2 border-[#001f3f]/10 object-cover" 
                    src="https://ui-avatars.com/api/?name={{ auth()->user()->getNombreCompletoAttribute() }}&background=001f3f&color=fff" 
                    alt="User">
            </div>

            <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                x-transition:enter="transition opacity duration-300"
                class="ml-3 flex flex-col whitespace-nowrap overflow-hidden">
                <span class="text-sm font-bold text-slate-800 dark:text-white leading-tight">
                    {{ auth()->user()->getNombreCompletoAttribute() }}
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">En línea</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                @foreach ($menuFiltrado as $groupIndex => $menuGroup)
                    <div>
                        <h2 class="mb-4 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'lg:justify-center' : 'justify-start px-2'">
                            <template x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>{{ $menuGroup['title'] }}</span>
                            </template>
                        </h2>

                        <ul class="flex flex-col gap-1">
                            @foreach ($menuGroup['items'] as $itemIndex => $item)
                                <li>
                                    @if (isset($item['subItems']) && count($item['subItems']) > 0)
                                        <button @click.stop="toggleSubmenu({{ $groupIndex }}, {{ $itemIndex }})"
                                            class="menu-item group w-full flex items-center px-3 py-2 rounded-lg transition-all duration-200"
                                            :class="[
                                                isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) 
                                                ? 'bg-[#001f3f] text-white shadow-lg shadow-[#001f3f]/20' 
                                                : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-900',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ? 'xl:justify-center' : 'xl:justify-start'
                                            ]">
                                            <span :class="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) ? 'text-white' : 'text-slate-500 group-hover:text-[#001f3f]'">
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>
                                            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="ml-3 font-bold text-sm">
                                                {{ $item['name'] }}
                                            </span>
                                            <svg x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="ml-auto w-4 h-4 transition-transform duration-200"
                                                :class="{'rotate-180 text-white': isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }})}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div x-show="isSubmenuOpen({{ $groupIndex }}, {{ $itemIndex }}) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)">
                                            <ul class="mt-1 space-y-1 ml-9">
                                                @foreach ($item['subItems'] as $subItem)
                                                    <li>
                                                        <a href="{{ $subItem['path'] }}" 
                                                            class="block py-2 px-3 text-sm rounded-md transition-colors"
                                                            :class="isActive('{{ $subItem['path'] }}') 
                                                            ? 'text-[#001f3f] dark:text-blue-400 font-black' 
                                                            : 'text-slate-500 dark:text-slate-400 hover:text-[#001f3f] dark:hover:text-blue-400'">
                                                            {{ $subItem['name'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @elseif(isset($item['path']))
                                        <a href="{{ $item['path'] }}" 
                                            class="menu-item group flex items-center px-3 py-2 rounded-lg transition-all duration-200"
                                            :class="[
                                                isActive('{{ $item['path'] }}') 
                                                ? 'bg-[#001f3f] text-white shadow-lg shadow-[#001f3f]/20' 
                                                : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-900',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'xl:justify-center' : 'justify-start'
                                            ]">
                                            <span :class="isActive('{{ $item['path'] }}') ? 'text-white' : 'text-slate-500 group-hover:text-[#001f3f]'">
                                                {!! MenuHelper::getIconSvg($item['icon']) !!}
                                            </span>
                                            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="ml-3 font-bold text-sm">
                                                {{ $item['name'] }}
                                            </span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </nav>
    </div>
</aside>

<div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.setMobileOpen(false)"
    class="fixed z-50 h-screen w-full bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>