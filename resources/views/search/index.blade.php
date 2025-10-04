@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-8 border-b-4 border-custom-yellow pb-2">
            Hasil Pencarian
        </h1>

        @if($query)
            <p class="mb-8 text-lg">Menampilkan hasil untuk: <span class="font-semibold">{{ $query }}</span></p>

            <div class="space-y-10">
                <!-- Hasil Berita -->
                @if($posts->isNotEmpty())
                    <div>
                        <h2 class="text-2xl font-bold text-custom-dark-blue mb-4">Berita</h2>
                        <ul class="space-y-3 list-disc list-inside">
                            @foreach($posts as $post)
                                <li><a href="{{ route('posts.show', $post->slug) }}" class="text-gray-700 hover:text-custom-yellow">{{ $post->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Hasil Halaman -->
                @if($pages->isNotEmpty())
                    <div>
                        <h2 class="text-2xl font-bold text-custom-dark-blue mb-4">Halaman</h2>
                        <ul class="space-y-3 list-disc list-inside">
                            @foreach($pages as $page)
                                <li><a href="{{ route('pages.show', $page->slug) }}" class="text-gray-700 hover:text-custom-yellow">{{ $page->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Hasil Agenda -->
                @if($events->isNotEmpty())
                    <div>
                        <h2 class="text-2xl font-bold text-custom-dark-blue mb-4">Agenda</h2>
                        <ul class="space-y-3 list-disc list-inside">
                            @foreach($events as $event)
                                <li><a href="{{ route('events.show', $event) }}" class="text-gray-700 hover:text-custom-yellow">{{ $event->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Jika tidak ada hasil sama sekali -->
                @if($posts->isEmpty() && $pages->isEmpty() && $events->isEmpty())
                    <p class="text-center text-gray-500">Tidak ada hasil yang ditemukan untuk pencarian Anda.</p>
                @endif
            </div>
        @else
            <p class="text-center text-gray-500">Silakan masukkan kata kunci untuk memulai pencarian.</p>
        @endif
    </div>
</main>
@endsection
