<x-filament-panels::page>
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name ?? 'Administrator' }} 👋</h1>
                <p class="text-sm opacity-90">
                Program Studi Teknik Informatika – Universitas Sulawesi Barat
            </p>
            </div>

            <div x-data="{ loading: false }" class="ml-auto flex items-center">
                <button @click="loading = true; window.location.reload();" :disabled="loading"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm transition-all duration-200 hover:scale-105 disabled:opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4" :class="{ 'animate-spin': loading }">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v.008h-4.992V9.348zM3 12a9 9 0 1115.477 6.41l-1.415-1.415A7.5 7.5 0 105.25 12H3z" />
                    </svg>
                    <span x-text="loading ? 'Refreshing...' : 'Refresh Data'"></span>
                </button>
            </div>


        </div>




        {{-- GRID STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @livewire(\App\Filament\Widgets\StatsOverview::class)
        </div>

        {{-- TABEL POSTINGAN TERBARU --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow p-4 ring-1 ring-gray-100 dark:ring-gray-800">
            @livewire(\App\Filament\Widgets\LatestPostsWidget::class)
        </div>

    </div>
</x-filament-panels::page>
