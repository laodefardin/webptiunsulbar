<!-- Footer -->
<footer class="bg-custom-dark-blue text-white">
    <div class="max-w-[1320px] mx-auto px-4 sm:px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center md:text-left">
            <div>
                <h4 class="text-lg font-semibold mb-4">
                    {{ $settings['program_study_name'] ?? 'Pendidikan Teknologi Informasi' }}</h4>
                <p class="text-gray-400 text-sm">
                    {{ $settings['university_name'] ?? 'Universitas Sulawesi Barat' }}<br>
                    {!! nl2br(
                        e(
                            $settings['footer_address'] ??
                                'Jl. Prof. Dr. Baharuddin Lopa, SH, Talumung<br>Majene, Sulawesi Barat, Indonesia',
                        ),
                    ) !!}
                </p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white">Visi & Misi</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Struktur Organisasi</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Kalender Akademik</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Panduan Skripsi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @if (isset($settings['footer_email']))
                        <li><i class="fas fa-envelope mr-2"></i> {{ $settings['footer_email'] }}</li>
                    @endif
                    @if (isset($settings['footer_phone']))
                        <li><i class="fas fa-phone mr-2"></i> {{ $settings['footer_phone'] }}</li>
                    @endif
                    @if (isset($settings['footer_whatsapp']))
                        <li><i class="fab fa-whatsapp mr-2"></i> {{ $settings['footer_whatsapp'] }}</li>
                    @endif
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                <div class="flex space-x-4 justify-center md:justify-start">
                    @if (isset($settings['footer_facebook']))
                        <a href="{{ $settings['footer_facebook'] }}" class="text-gray-400 hover:text-white"><i
                                class="fab fa-facebook-f fa-lg"></i></a>
                    @endif
                    @if (isset($settings['footer_instagram']))
                    <a href="{{ $settings['footer_instagram'] }}" class="text-gray-400 hover:text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    @endif
                    @if (isset($settings['footer_youtube']))
                    <a href="{{ $settings['footer_youtube'] }}" class="text-gray-400 hover:text-white"><i class="fab fa-youtube fa-lg"></i></a>
                    @endif
                    @if (isset($settings['footer_linkedin']))
                    <a href="{{ $settings['footer_linkedin'] }}" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ $settings['program_study_name'] ?? 'Pendidikan Teknologi Informasi' }},
            {{ $settings['university_name'] ?? 'Universitas Sulawesi Barat' }}. All Rights Reserved.
        </div>
    </div>
</footer>

<script>
    // Hamburger menu toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }


    // Mobile accordion menu toggle
    document.querySelectorAll('.mobile-menu-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const submenu = button.nextElementSibling;
            submenu.classList.toggle('hidden');
            const icon = button.querySelector('i');
            icon.classList.toggle('rotate-180');
        });
    });

    // FAQ Accordion
    document.querySelectorAll('.accordion-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');

            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                icon.classList.remove('rotate-180');
            } else {
                // Close other open accordions if you want only one to be open at a time
                document.querySelectorAll('.accordion-content').forEach(item => {
                    if (item !== content) {
                        item.style.maxHeight = null;
                        item.previousElementSibling.querySelector('i').classList.remove(
                            'rotate-180');
                    }
                });

                content.style.maxHeight = content.scrollHeight + "px";
                icon.classList.add('rotate-180');
            }
        });
    });
</script>


{{-- Alpine.js and its collapse plugin for smooth transitions --}}
<script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
