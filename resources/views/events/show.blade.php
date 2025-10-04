@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

        <!-- Judul Agenda -->
        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-4">
            {{ $event->title }}
        </h1>

        <!-- Info Meta: Tanggal, Waktu, Lokasi -->
        <div class="text-gray-500 text-sm mb-6 flex flex-wrap items-center gap-x-4 gap-y-2">
            <span>
                <i class="fas fa-calendar-alt fa-fw mr-1"></i>
                {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d F Y') }}
            </span>
            @if($event->start_time)
            <span>
                <i class="fas fa-clock fa-fw mr-1"></i>
                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                @if($event->end_time)
                 - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                @endif
            </span>
            @endif
            <span>
                <i class="fas fa-map-marker-alt fa-fw mr-1"></i>
                {{ $event->location }}
            </span>
        </div>

        <!-- Gambar Utama -->
        @if($event->image_url)
            <img src="{{ Storage::url($event->image_url) }}" alt="{{ $event->title }}" class="w-full h-auto object-cover rounded-lg mb-8">
        @endif

        <!-- Deskripsi Agenda -->
        @if($event->description)
            <div class="prose max-w-none">
                {!! $event->description !!}
            </div>
        @endif

        <!-- Tombol Kembali -->
        <div class="mt-12">
            <a href="{{ url('/') }}" class="text-custom-dark-blue font-semibold hover:underline">
                &larr; Kembali ke Beranda
            </a>
        </div>

    </div>
</main>
@endsection
