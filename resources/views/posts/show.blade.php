@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

        <!-- Judul Berita -->
        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-4">
            {{ $post->title }}
        </h1>

        <!-- Info Meta: Kategori & Tanggal -->
        <div class="text-gray-500 text-sm mb-6">
            <span>Kategori: {{ $post->category }}</span>
            <span class="mx-2">&bull;</span>
            <span>Dipublikasikan pada: {{ \Carbon\Carbon::parse($post->published_at)->translatedFormat('d F Y') }}</span>
        </div>

        <!-- Gambar Utama -->
        @if($post->image_url)
            <img src="{{ Storage::url($post->image_url) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-lg mb-8">
        @endif

        <!-- Konten Berita -->
        <div class="prose max-w-none">
            {!! $post->content !!}
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-12">
            <a href="{{ url('/') }}" class="text-custom-dark-blue font-semibold hover:underline">
                &larr; Kembali ke Beranda
            </a>
        </div>

    </div>
</main>
@endsection
