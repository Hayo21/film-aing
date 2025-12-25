<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Film Aing | Ngaloco Movies & Anime</title>

    <style>
        body {
            background-color: #0F172A;
        }

        /* === ANIMATIONS === */
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

        .anim-item {
            opacity: 0;
        }

        .is-active .anim-badge {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .is-active .anim-title {
            animation: slideUp 0.8s ease-out 0.2s forwards;
        }

        .is-active .anim-desc {
            animation: slideUp 0.8s ease-out 0.4s forwards;
        }

        .is-active .anim-btn {
            animation: fadeIn 0.8s ease-out 0.6s forwards;
        }

        /* === CARD HOVER EFFECTS === */
        .movie-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-8px);
        }

        .movie-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.7), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }

        .movie-card:hover .movie-card-overlay {
            opacity: 1;
        }

        .movie-card-content {
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .movie-card:hover .movie-card-content {
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <x-navbar />

    {{-- HERO CAROUSEL --}}
    <div class="relative w-full h-[55vh] md:h-[75vh] overflow-hidden bg-black group" id="carousel-wrapper">

        {{-- SLIDES TRACK --}}
        <div class="flex h-full transition-transform duration-700 ease-in-out" id="track">
            @foreach ($slides as $index => $slide)
                <div class="w-full h-full flex-shrink-0 relative slide-item {{ $index === 0 ? 'is-active' : '' }}">

                    {{-- Background Image --}}
                    <img src="{{ $slide['img'] }}" alt="{{ $slide['title'] }}" class="w-full h-full object-cover"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>

                    {{-- Content --}}
                    <div class="absolute inset-0 flex items-center mt-3">
                        <div class="container mx-auto px-8 md:px-16 max-w-4xl">

                            <span
                                class="anim-item anim-badge inline-block px-3 py-1 {{ $slide['color'] }} text-white text-sm font-semibold rounded mb-4 mt-10">
                                {{ $slide['badge'] }}
                            </span>

                            <h1 class="anim-item anim-title text-4xl md:text-5xl lg:text-7xl font-bold text-white mb-4">
                                {{ $slide['title'] }}
                            </h1>

                            <p class="anim-item anim-desc text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                                {{ $slide['desc'] }}
                            </p>

                            {{-- Rating Badge --}}
                            @if ($slide['rating'] > 0)
                                <div class="anim-item anim-desc flex items-center gap-2 mb-4">
                                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-white text-xl font-bold">{{ $slide['rating'] }}</span>
                                    <span class="text-gray-400 text-sm">/ 10</span>
                                </div>
                            @endif

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
        <button onclick="moveSlide(1)"
            class="hidden md:flex absolute right-8 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full items-center justify-center text-white backdrop-blur z-20 transition hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <button onclick="moveSlide(-1)"
            class="hidden md:flex absolute left-8 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/30 rounded-full items-center justify-center text-white backdrop-blur z-20 transition hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- INDICATORS --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20">
            @foreach ($slides as $i => $s)
                <button onclick="jumpToSlide({{ $i }})"
                    class="indicator w-3 h-3 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white' }}"></button>
            @endforeach
        </div>
    </div>

    {{-- CONTENT SECTIONS --}}
    <div class="container mx-auto px-8 md:px-16 py-12">

        {{-- POPULAR MOVIES --}}
        @if (!empty($movies))
            <section class="mb-12">
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="w-1 h-8 bg-red-600 rounded"></span>
                    Popular Movies
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach ($movies as $movie)
                        @include('homes.partials.movie-card', ['item' => $movie, 'type' => 'movie'])
                    @endforeach
                </div>
            </section>
        @endif

        {{-- TOP ANIME --}}
        @if (!empty($animes))
            <section>
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="w-1 h-8 bg-purple-600 rounded"></span>
                    Top Anime
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach ($animes as $anime)
                        @include('homes.partials.movie-card', ['item' => $anime, 'type' => 'anime'])
                    @endforeach
                </div>
            </section>
        @endif

    </div>

    {{-- CAROUSEL SCRIPT --}}
    <script>
        const track = document.getElementById('track');
        const slides = document.querySelectorAll('.slide-item');
        const dots = document.querySelectorAll('.indicator');
        let currentSlide = 0;
        let autoPlayTimer;

        function updateCarousel() {
            track.style.transform = `translateX(-${currentSlide * 100}%)`;

            slides.forEach((slide, idx) => {
                if (idx === currentSlide) {
                    slide.classList.remove('is-active');
                    void slide.offsetWidth;
                    slide.classList.add('is-active');
                } else {
                    slide.classList.remove('is-active');
                }
            });

            dots.forEach((dot, i) => {
                dot.className = `indicator w-3 h-3 rounded-full transition-all duration-300 ${
                    i === currentSlide ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white'
                }`;
            });

            resetAutoPlay();
        }

        function moveSlide(direction) {
            currentSlide = (currentSlide + direction + slides.length) % slides.length;
            updateCarousel();
        }

        function jumpToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }

        function resetAutoPlay() {
            clearInterval(autoPlayTimer);
            autoPlayTimer = setInterval(() => moveSlide(1), 5000);
        }

        let touchStartX = 0;
        track.addEventListener('touchstart', e => touchStartX = e.touches[0].clientX);
        track.addEventListener('touchend', e => {
            const diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) {
                moveSlide(diff > 0 ? 1 : -1);
            }
        });

        resetAutoPlay();
    </script>

</body>

</html>
