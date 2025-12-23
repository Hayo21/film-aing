<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Film Aing</title>
    <style>
        body {
            background-color: #0F172A;
        }

        /* --- 1. Definisi Animasi (Persis seperti kode asli Anda) --- */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* --- 2. State Awal (Sembunyi sebelum animasi jalan) --- */
        .anim-item {
            opacity: 0;
        }

        /* --- 3. Trigger Animasi --- */
        /* Animasi hanya jalan jika parent slide memiliki class 'is-active' */

        /* Badge: Langsung muncul */
        .is-active .anim-badge {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Judul: Delay 0.2 detik */
        .is-active .anim-title {
            animation: slideUp 0.8s ease-out 0.2s forwards;
        }

        /* Deskripsi: Delay 0.4 detik */
        .is-active .anim-desc {
            animation: slideUp 0.8s ease-out 0.4s forwards;
        }

        /* Tombol: Delay 0.6 detik */
        .is-active .anim-btn {
            animation: fadeIn 0.8s ease-out 0.6s forwards;
        }
    </style>
</head>

<body>

    <x-navbar />

    {{-- DATA SLIDES --}}
    @php
        $slides = [
            [
                'img' => 'https://images.unsplash.com/photo-1616530940355-351fabd9524b?w=1920',
                'badge' => 'NEW RELEASE',
                'color' => 'bg-red-600',
                'title' => 'The Dark Knight',
                'desc' =>
                    'Ketika ancaman yang dikenal sebagai Joker muncul dari masa lalunya, Batman harus menghadapi ujian terbesar untuk memerangi ketidakadilan.',
            ],
            [
                'img' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=1920',
                'badge' => 'TRENDING',
                'color' => 'bg-yellow-500 text-black',
                'title' => 'Inception',
                'desc' =>
                    'Seorang pencuri yang mencuri rahasia perusahaan melalui teknologi berbagi mimpi diberi tugas terbalik: menanamkan ide ke dalam pikiran CEO.',
            ],
            [
                'img' => 'https://images.unsplash.com/photo-1594908900066-3f47337549d8?w=1920',
                'badge' => 'POPULAR',
                'color' => 'bg-purple-600',
                'title' => 'Interstellar',
                'desc' =>
                    'Tim penjelajah memanfaatkan lubang cacing yang baru ditemukan untuk melampaui batas perjalanan ruang angkasa manusia dan menaklukkan jarak luas.',
            ],
        ];
    @endphp

    {{-- CAROUSEL CONTAINER --}}
    <div class="relative w-full h-[55vh] md:h-[65vh] overflow-hidden bg-black group" id="carousel-wrapper">

        {{-- SLIDES TRACK --}}
        <div class="flex h-full transition-transform duration-700 ease-in-out" id="track">
            @foreach ($slides as $index => $slide)
                {{-- Tambahkan data-index agar JS tahu ini slide keberapa --}}
                <div class="w-full h-full flex-shrink-0 relative slide-item {{ $index === 0 ? 'is-active' : '' }}">

                    {{-- Background Image --}}
                    <img src="{{ $slide['img'] }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute inset-0 flex items-center">
                        <div class="container mx-auto px-8 md:px-16 max-w-2xl">

                            <span
                                class="anim-item anim-badge inline-block px-3 py-1 {{ $slide['color'] }} text-white text-sm font-semibold rounded mb-4 mt-10">
                                {{ $slide['badge'] }}
                            </span>

                            <h1 class="anim-item anim-title text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4">
                                {{ $slide['title'] }}
                            </h1>

                            <p
                                class="anim-item anim-desc text-base md:text-lg lg:text-xl text-gray-300 mb-6 line-clamp-3 md:line-clamp-none">
                                {{ $slide['desc'] }}
                            </p>

                            <div class="anim-item anim-btn flex gap-4">
                                <button
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition hover:scale-105">
                                    Tonton Sekarang
                                </button>
                                <button
                                    class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur text-white font-semibold rounded-lg transition hover:scale-105">
                                    Info Lengkap
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- NAV BUTTONS (Desktop) --}}
        <button onclick="move(1)"
            class="hidden md:flex absolute right-8 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full items-center justify-center text-white backdrop-blur z-20 transition hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <button onclick="move(-1)"
            class="hidden md:flex absolute left-8 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full items-center justify-center text-white backdrop-blur z-20 transition hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- INDICATORS --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20">
            @foreach ($slides as $i => $s)
                <button onclick="jumpTo({{ $i }})"
                    class="indicator w-3 h-3 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white' }}"></button>
            @endforeach
        </div>
    </div>

    <script>
        const track = document.getElementById('track');
        const slides = document.querySelectorAll('.slide-item');
        const dots = document.querySelectorAll('.indicator');
        let curr = 0;
        let timer;

        function update() {
            // 1. Geser Track
            track.style.transform = `translateX(-${curr * 100}%)`;

            // 2. Reset & Trigger Animasi
            slides.forEach((slide, idx) => {
                // Logika: Hapus class is-active dulu, lalu tambah lagi jika index cocok
                // Ini memicu ulang CSS Animation (Re-flow)
                if (idx === curr) {
                    slide.classList.remove('is-active'); // Hapus sebentar
                    void slide.offsetWidth; // Force Reflow (trik ajaib CSS agar animasi restart)
                    slide.classList.add('is-active');
                } else {
                    slide.classList.remove('is-active');
                }
            });

            // 3. Update Dots
            dots.forEach((d, i) => {
                d.className =
                    `indicator w-3 h-3 rounded-full transition-all duration-300 ${i === curr ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white'}`;
            });

            resetTimer();
        }

        function move(dir) {
            curr = (curr + dir + slides.length) % slides.length;
            update();
        }

        function jumpTo(idx) {
            curr = idx;
            update();
        }

        function resetTimer() {
            clearInterval(timer);
            timer = setInterval(() => move(1), 5000);
        }

        // Swipe Mobile Simple
        let startX = 0;
        track.addEventListener('touchstart', e => startX = e.touches[0].clientX);
        track.addEventListener('touchend', e => {
            if (startX - e.changedTouches[0].clientX > 50) move(1);
            if (e.changedTouches[0].clientX - startX > 50) move(-1);
        });

        // Init
        resetTimer();
    </script>

    <h1 class="mt-5" style="color: white">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Velit vitae totam voluptates et alias explicabo
        voluptatibus. Facilis reprehenderit suscipit excepturi debitis saepe doloremque facere alias, ipsa quibusdam
        porro soluta odit cumque quidem fuga nesciunt fugiat eligendi assumenda sunt voluptas eaque provident, neque
        sequi. Harum nesciunt eligendi quasi hic fugit blanditiis ea, quibusdam minus error. Blanditiis adipisci iure
        sint possimus animi reprehenderit tempora obcaecati, distinctio accusantium error mollitia perferendis quidem
        explicabo doloribus culpa provident maiores quia unde. Facilis vel, aut doloremque consectetur suscipit
        voluptatibus? Enim architecto cupiditate sit, at magnam dolorum, sed reprehenderit omnis recusandae officiis
        saepe modi temporibus quisquam iure?
    </h1>
</body>

</html>
