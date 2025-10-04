@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-8 border-b-4 border-custom-yellow pb-2">
            Dosen & Tenaga Pendidik
        </h1>

        <div class="space-y-8">
            @forelse($lecturers as $lecturer)
                <div class="flex flex-col sm:flex-row items-center gap-6 p-4 border rounded-lg shadow-sm">
                    <img src="{{ $lecturer->photo_url ? Storage::url($lecturer->photo_url) : 'https://placehold.co/150' }}"
                         alt="Foto {{ $lecturer->name }}"
                         class="w-32 h-32 object-cover rounded-full flex-shrink-0">
                    <div class="text-center sm:text-left">
                        <h2 class="text-2xl font-bold text-custom-dark-blue">{{ $lecturer->name }}</h2>
                        <p class="text-lg text-gray-700 font-semibold">{{ $lecturer->position }}</p>
                        @if($lecturer->nidn)
                            <p class="text-sm text-gray-500 mt-1">NIDN: {{ $lecturer->nidn }}</p>
                        @endif
                         @if($lecturer->email)
                            <p class="text-sm text-gray-500">Email: {{ $lecturer->email }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Data dosen dan staff belum tersedia.</p>
            @endforelse
        </div>

    </div>
</main>
@endsection
