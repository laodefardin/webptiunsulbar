@extends('layouts.app')

@section('content')
<main class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">

        <h1 class="text-4xl font-bold text-custom-dark-blue font-serif-display mb-2">
            Kurikulum Program Studi
        </h1>
        <p class="text-gray-600 mb-8">Struktur kurikulum adalah susunan mata kuliah dan materi yang dirancang untuk membentuk program studi dalam pendidikan.</p>

        <div class="space-y-4">
            @foreach($semesters as $semester)
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center py-4 px-5 text-left text-gray-800 font-semibold bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <span>{{ $semester->name }}</span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{'rotate-180': open}"></i>
                </button>
                <div x-show="open" x-collapse>
                    <div class="border rounded-b-lg -mt-1 p-1">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="p-3 text-left font-semibold">Kode</th>
                                        <th class="p-3 text-left font-semibold">Mata Kuliah</th>
                                        <th class="p-3 text-center font-semibold">SKS</th>
                                        <th class="p-3 text-left font-semibold">Sifat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($semester->courses as $course)
                                    <tr class="border-b last:border-b-0">
                                        <td class="p-3">{{ $course->code }}</td>
                                        <td class="p-3">
                                            @if($course->rps_link)
                                                <a href="{{ $course->rps_link }}" target="_blank" rel="noopener noreferrer" class="text-custom-dark-blue hover:underline font-semibold">
                                                    {{ $course->name }} <i class="fas fa-external-link-alt fa-xs ml-1"></i>
                                                </a>
                                            @else
                                                {{ $course->name }}
                                            @endif
                                        </td>
                                        <td class="p-3 text-center">{{ $course->credits }}</td>
                                        <td class="p-3">{{ $course->type }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="p-3 text-center text-gray-500">Belum ada mata kuliah untuk semester ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
{{-- Alpine.js and its collapse plugin for smooth transitions --}}
<script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
