<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendidikan Teknologi Informasi - Universitas Sulawesi Barat</title>
    @if (isset($settings['site_logo']) && $settings['site_logo'])
        <link rel="icon" href="{{ Storage::url($settings['site_logo']) }}" type="image/png">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Montserrat:wght@300;400;500;800&family=Public+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #ffffff;
            /* Set background to white */
        }

        .font-menu {
            font-family: 'Montserrat', sans-serif;
        }

        .font-serif-display {
            font-family: 'Lora', serif;
        }

        /* Custom Colors based on reference image */
        .bg-custom-dark-blue {
            background-color: #0d1b3e;
        }

        .text-custom-dark-blue {
            color: #0d1b3e;
        }

        .border-custom-dark-blue {
            border-color: #0d1b3e;
        }

        .bg-custom-yellow {
            background-color: #f2c204;
        }

        .text-custom-yellow {
            color: #f2c204;
        }

        .border-custom-yellow {
            border-color: #f2c204;
        }

        .hover\:bg-custom-yellow-dark:hover {
            background-color: #d9ac04;
        }

        .hover\:bg-custom-dark-blue-light:hover {
            background-color: #1a2c5a;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0d1b3e;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f2c204;
            display: inline-block;
        }

        /* Dropdown arrow transition */
        .mobile-menu-toggle i,
        .accordion-toggle i {
            transition: transform 0.3s ease;
        }

        .text-shadow {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }

        .top-bar-link {
            color: #777;
        }

        .top-bar-link:hover {
            color: #000;
        }

        /* Accordion smooth transition */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out;
        }

        /* Styling for content from Rich Editor */
        .prose img {
            border-radius: 0.5rem;
        }

        .prose h1,
        .prose h2,
        .prose h3 {
            color: #0d1b3e;
        }

        /* Hide auto-generated captions from Rich Editor */
        .prose figcaption {
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }
        
    </style>
</head>

<body>

    {{-- Include Header --}}
    @include('partials._header')

    {{-- Content section that will be filled by other views --}}
    @yield('content')

    {{-- Include Footer --}}
    @include('partials._footer')

</body>

</html>
