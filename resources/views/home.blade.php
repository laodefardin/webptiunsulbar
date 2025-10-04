@extends('layouts.app')

@section('content')
    <main class="max-w-[1320px] mx-auto bg-white">
        <!-- Banner Image -->
        <div class="relative">
            @foreach ($sliders as $slider)
            <div class="w-full bg-cover bg-center flex items-center justify-center px-6 pt-32 pb-56"
                style="background-image: url('{{ Storage::url($slider->image_url) }}');">
            @endforeach
                <div class="absolute inset-0 bg-black opacity-50"></div>
                <div class="relative text-center text-white">
                    <p class="font-serif-display text-2xl md:text-4xl">Program Studi</p>
                    <div class="font-menu font-extrabold uppercase tracking-wide">
                        <h2 class="text-4xl mt-2">
                            PENDIDIKAN
                            <span class="relative inline-block">
                                TEKNOLOGI INFORMASI
                                <svg class="absolute left-[-5%] w-[110%]" style="height: 25px; bottom: -8px;"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
                                    <path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"
                                        fill="none" stroke="#f2c204" stroke-width="20"></path>
                                </svg>
                            </span>
                        </h2>
                    </div>
                    <p class="text-base md:text-lg text-gray-200 mt-8">Fakultas Keguruan dan Ilmu Pendidikan,
                        Universitas Sulawesi Barat</p>
                </div>
            </div>
        </div>

        <!-- Info Cards Section -->
        @if ($featuredPages->isNotEmpty())
            <div class="px-4 sm:px-6 pb-8 -mt-20 relative z-10">
                @php
                    $cardColors = ['#ffdd00', '#eecb00', '#ddbb00'];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 overflow-hidden">
                    @foreach ($featuredPages as $page)
                        <div class="p-6 flex items-center justify-center text-center md:justify-start md:text-left gap-4 cursor-pointer text-gray-800 transition-all duration-300 hover:brightness-95"
                            style="background-color: {{ $cardColors[$loop->index % count($cardColors)] }};">
                            <i class="fas fa-graduation-cap text-3xl"></i>
                            <div>
                                <h3 class="font-bold text-lg">{{ $page->menu_title ?? $page->title }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 md:grid-cols-{{ $featuredPages->count() }} gap-px bg-gray-200 overflow-hidden">
                    @foreach ($featuredPages as $page)
                        <!-- Card -->
                        <div class="bg-white">
                            <img src="{{ $page->image_url ? Storage::url($page->image_url) : 'https://placehold.co/600x400?text=Image' }}"
                                alt="{{ $page->title }}" class="w-full h-40 object-cover">
                            <div class="p-6">
                                <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                    {!! Str::limit(strip_tags($page->content), 150) !!}
                                </p>
                                <a href="{{ route('pages.show', $page->slug) }}"
                                    class="text-yellow-700 font-semibold text-sm hover:underline">Selengkapnya &raquo;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Campus News Section -->
        <div class="px-4 sm:px-6 py-8">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between md:items-start mb-8">
                <!-- Left Side: Title and Subtitle -->
                <div class="flex-grow mb-4 md:mb-0">
                    <h2 class="text-3xl font-bold text-custom-dark-blue font-serif-display inline-block">Rilis Berita
                    </h2>
                    <div class="w-full h-1 bg-custom-yellow mt-1"></div>
                    <p class="text-gray-600 mt-2">Berisi informasi maupun pengumuman terkait Program Studi Pendidikan
                        Teknologi Informasi.</p>
                </div>

                <!-- Right Side: View All Link -->
                <div class="flex-shrink-0 ml-0 md:ml-4">
                    <a href="#"
                        class="text-custom-dark-blue font-semibold text-sm uppercase tracking-wider whitespace-nowrap border-b-2 border-custom-dark-blue pb-1">
                        <span>Lihat Berita Lainnya</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- News Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($posts as $post)
                    <!-- News Card -->
                    <div class="bg-white group">
                        <div class="overflow-hidden">
                            <img src="{{ Storage::url($post->image_url) }}" alt="{{ $post->title }}"
                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-2">{{ $post->category }}</p>
                            <h3 class="font-bold text-lg text-gray-800 group-hover:text-[#ffdd00] transition-colors">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada berita yang dipublikasikan.</p>
                @endforelse
            </div>
        </div>

        <!-- Agenda Section -->
        <div class="px-4 sm:px-6 py-8">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between md:items-start mb-8">
                <!-- Left Side: Title and Subtitle -->
                <div class="flex-grow mb-4 md:mb-0">
                    <h2 class="text-3xl font-bold text-custom-dark-blue font-serif-display inline-block">Agenda</h2>
                    <div class="w-full h-1 bg-custom-yellow mt-1"></div>
                    <p class="text-gray-600 mt-2">Acara-acara yang diadakan oleh fakultas.</p>
                </div>

                <!-- Right Side: View All Link -->
                <div class="flex-shrink-0 ml-0 md:ml-4">
                    <a href="#"
                        class="text-custom-dark-blue font-semibold text-sm uppercase tracking-wider whitespace-nowrap border-b-2 border-custom-dark-blue pb-1">
                        <span>Lihat Agenda Lainnya</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Agenda Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <!-- Agenda Card -->
                    <div class="bg-white group">
                        <div class="p-4 bg-gray-50 rounded-lg shadow-sm flex flex-col h-full">
                            <div class="h-64 mb-4 overflow-hidden">
                                <img src="{{ Storage::url($event->image_url) }}" alt="{{ $event->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="text-center flex-shrink-0">
                                    <p class="text-3xl font-bold text-red-600">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</p>
                                    <p class="text-sm uppercase font-semibold text-gray-600">
                                        {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('M') }}</p>
                                    <div class="w-8 h-0.5 bg-red-600 mx-auto mt-1"></div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800">
                                        <a href="{{ route('events.show', $event) }}"
                                            class="hover:text-[#ffdd00] transition-colors">{{ $event->title }}</a>
                                    </h3>
                                    @if ($event->start_time)
                                        <p class="text-sm text-gray-500 mt-1"><i class="fas fa-clock fa-fw mr-1"></i>
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                            @if ($event->end_time)
                                                - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                            @endif
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt fa-fw mr-1"></i>
                                        {{ $event->location }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada agenda yang akan datang.</p>
                @endforelse
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <!-- Swiper JS -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endsection
