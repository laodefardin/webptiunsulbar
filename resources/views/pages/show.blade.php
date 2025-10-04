@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

        {{-- Judul Halaman --}}
        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-8">
            {{ $page->title }}
        </h1>

        {{-- Gambar Utama (Thumbnail) --}}
        @if($page->image_url)
            <img src="{{ Storage::url($page->image_url) }}" alt="{{ $page->title }}" class="w-full h-auto object-cover rounded-lg mb-8">
        @endif

        {{-- Konten Halaman --}}
        <div class="prose max-w-none">
            {!! $page->content !!}
        </div>

    </div>
</main>
@endsection
