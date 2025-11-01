<div class="flex items-center gap-x-4">
    {{-- Cek apakah logo ada --}}
    @if($logoUrl)
        {{-- <img src="{{ $logoUrl }}" alt="Logo" class="h-11 w-auto"> --}}
        <img src="{{ $logoUrl ?? asset('images/logo-unsulbar.png') }}" alt="Logo" class="h-10 w-auto rounded-lg shadow-md">

    @endif

 <div class="flex flex-col text-left">
        <span class="text-base font-semibold text-gray-900 dark:text-white leading-tight">
            Pendidikan
        </span>
        <span class="text-base font-semibold text-gray-900 dark:text-white leading-tight">
            Teknologi Informasi
        </span>
    </div>
</div>


