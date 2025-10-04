@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">

        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-8 border-b-4 border-custom-yellow pb-2">
            Galeri Kegiatan
        </h1>

        @if($images->isNotEmpty())
            <div x-data="{ open: false, image: '' }">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($images as $image)
                        <div @click="open = true; image = '{{ Storage::url($image->image_url) }}'" class="cursor-pointer group">
                            <img src="{{ Storage::url($image->image_url) }}"
                                 alt="{{ $image->caption ?? 'Gambar Galeri' }}"
                                 class="w-full h-48 object-cover rounded-lg shadow-md group-hover:opacity-75 transition-opacity">
                            @if($image->caption)
                                <p class="text-sm text-gray-600 mt-2 text-center">{{ $image->caption }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox Modal -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
                     @click.away="open = false"
                     style="display: none;">

                    <button @click="open = false" class="absolute top-4 right-4 text-white text-3xl">&times;</button>

                    <img :src="image" class="max-w-[90vw] max-h-[90vh] rounded-lg">
                </div>
            </div>
        @else
            <p class="text-center text-gray-500">Belum ada gambar di galeri.</p>
        @endif

    </div>
</main>
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
