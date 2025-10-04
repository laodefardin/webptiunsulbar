<!-- Top Bar -->
<div class="bg-custom-yellow">
    <div
        class="max-w-[1320px] mx-auto px-4 sm:px-6 py-2 flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0">
        <!-- Left Links -->
        <div class="flex space-x-4 sm:space-x-6 text-sm font-light tracking-wide">
            @foreach($topNavItems as $item)
                <a href="{{ $item->url }}" target="{{ $item->target }}" class="top-bar-link transition-colors duration-200">{{ $item->title }}</a>
            @endforeach
        </div>
        <!-- Right Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="relative w-full sm:w-auto">
            <input type="text" name="q" placeholder="Pencarian..." value="{{ request('q') }}"
                class="bg-white border-gray-300 rounded-full pl-4 pr-10 py-1 text-xs focus:outline-none focus:border-custom-dark-blue w-full sm:w-48">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Header & Navigation -->
<header class="bg-white shadow-lg sticky top-0 z-50">
    <!-- Main Header -->
    <div class="relative text-white bg-cover bg-center"
        style="background-image: url('{{ asset('storage/settings/header.png') }}');">
        <!-- Header Content -->
        <div class="relative max-w-[1320px] mx-auto px-4 sm:px-6 py-8 md:py-12">
            <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-4">
                @if(isset($settings['site_logo']) && $settings['site_logo'])
                    <img src="{{ Storage::url($settings['site_logo']) }}" alt="Logo Website" class="h-16 md:h-20 w-auto md:mr-6">
                @endif
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-shadow">{{ $settings['program_study_name'] ?? 'Pendidikan Teknologi Informasi' }}</h1>
                    <p class="text-base text-gray-200 text-shadow mt-1">{{ $settings['faculty_name'] ?? 'Fakultas Keguruan dan Ilmu Pendidikan' }}</p>
                    <p class="text-sm text-gray-300 text-shadow">{{ $settings['university_name'] ?? 'Universitas Sulawesi Barat' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-custom-dark-blue text-custom-yellow shadow-md font-menu">
        <div class="max-w-[1320px] mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="hidden lg:flex items-center font-light text-sm tracking-wider">
                    {{-- Static Home Link --}}
                    <a href="{{ url('/') }}" class="py-4 px-4 hover:bg-white hover:text-custom-dark-blue transition-colors duration-200">HOME</a>

                    {{-- Loop through main navigation items --}}
                    @foreach($mainNavItems as $item)
                        @if($item->children->isNotEmpty())
                            <!-- Dropdown Menu -->
                            <div class="relative group">
                                <a href="{{ $item->url }}" target="{{ $item->target }}" class="py-4 px-4 group-hover:bg-white group-hover:text-custom-dark-blue transition-colors duration-200 flex items-center">
                                    {{ $item->title }} <i class="fas fa-chevron-down ml-2 text-xs"></i>
                                </a>
                                <div class="absolute left-0 mt-0 w-56 bg-white rounded-b-lg shadow-xl hidden group-hover:block z-50">
                                    @foreach($item->children as $child)
                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-4 py-3 text-custom-dark-blue text-sm hover:bg-gray-100">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Simple Link -->
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="py-4 px-4 hover:bg-white hover:text-custom-dark-blue transition-colors duration-200">{{ $item->title }}</a>
                        @endif
                    @endforeach
                </div>
                <button id="menu-btn" class="lg:hidden text-2xl p-2 text-custom-yellow">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-custom-dark-blue text-custom-yellow p-4 font-menu">
        {{-- Static Home Link for Mobile --}}
        <a href="{{ url('/') }}" class="block py-2 px-4 hover:bg-custom-dark-blue-light rounded">Home</a>

        @foreach($mainNavItems as $item)
            @if($item->children->isNotEmpty())
                <!-- Accordion -->
                <div>
                    <button class="w-full flex justify-between items-center py-2 px-4 hover:bg-custom-dark-blue-light rounded mobile-menu-toggle">
                        <span>{{ $item->title }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="pl-6 hidden">
                        @foreach($item->children as $child)
                            <a href="{{ $child->url }}" target="{{ $child->target }}" class="block py-2 px-4 text-sm hover:bg-custom-dark-blue-light rounded">{{ $child->title }}</a>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Simple Link -->
                <a href="{{ $item->url }}" target="{{ $item->target }}" class="block py-2 px-4 hover:bg-custom-dark-blue-light rounded">{{ $item->title }}</a>
            @endif
        @endforeach
    </div>
</header>

