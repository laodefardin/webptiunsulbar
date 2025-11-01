@php
    /** @var \App\Models\Menu $menu */
    $menu = $getRecord();

    // Ambil semua menu item (2 level cukup untuk preview)
    $roots = $menu->menuItems()
        ->with('children.children')
        ->whereNull('parent_id')
        ->orderBy('order')
        ->get();

    // Definisikan fungsi hanya sekali
    if (!function_exists('renderTreeMenu')) {
        function renderTreeMenu($nodes, $level = 0)
        {
            $html = '<ul class="pl-' . ($level ? 4 : 0) . ' space-y-1">';
            foreach ($nodes as $node) {
                $html .= '<li>';
                $html .= '<div class="flex items-center gap-2">';
                $html .= '<div class="h-1.5 w-1.5 rounded-full bg-gray-400/70"></div>';
                $html .= '<span class="font-medium text-gray-800">' . e($node->title) . '</span>';
                if ($node->url) {
                    $html .= '<span class="text-xs text-gray-500 truncate max-w-[220px]">' . e($node->url) . '</span>';
                }
                $html .= '</div>';

                if ($node->children && $node->children->isNotEmpty()) {
                    $html .= renderTreeMenu($node->children, $level + 1);
                }

                $html .= '</li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }
@endphp

<div x-data="{ open: false }" class="p-2 rounded-lg bg-gray-50 border border-gray-100">
    <button
        @click="open = !open"
        class="text-xs font-semibold text-primary-600 hover:text-primary-700 hover:underline"
        type="button"
    >
        <span x-show="!open">Tampilkan Struktur</span>
        <span x-show="open">Sembunyikan Struktur</span>
    </button>

    <div x-show="open" x-collapse class="mt-2">
        @if ($roots->isEmpty())
            <div class="text-xs text-gray-500">Belum ada item menu.</div>
        @else
            {!! renderTreeMenu($roots, 0) !!}
        @endif
    </div>
</div>
