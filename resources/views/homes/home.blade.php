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

        /* --- Card Hover Effects --- */
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

    {{-- DATA SLIDES - Ambil dari API --}}
    @php
        // Helper function untuk memotong teks berdasarkan jumlah kata
        function limitWords($text, $limit = 25)
        {
            $words = explode(' ', $text);
            if (count($words) > $limit) {
                return implode(' ', array_slice($words, 0, $limit)) . '...';
            }
            return $text;
        }

        $slides = [];

        // Ambil 2 Film Terpopuler dari TMDB
        if (!empty($movies)) {
            foreach (array_slice($movies, 0, 2) as $index => $movie) {
                $slides[] = [
                    'img' =>
                        'https://image.tmdb.org/t/p/original' .
                        ($movie['backdrop_path'] ?? ($movie['poster_path'] ?? '')),
                    'badge' => $index === 0 ? 'TOP MOVIE' : 'TRENDING MOVIE',
                    'color' => $index === 0 ? 'bg-red-600' : 'bg-yellow-500 text-black',
                    'title' => $movie['title'] ?? 'Unknown Title',
                    'desc' => limitWords($movie['overview'] ?? 'No description available.', 25),
                    'rating' => $movie['vote_average'] ?? 0,
                ];
            }
        }

        // Ambil 2 Anime Terpopuler dari Jikan
        if (!empty($animes)) {
            foreach (array_slice($animes, 0, 2) as $index => $anime) {
                $slides[] = [
                    'img' => $anime['images']['jpg']['large_image_url'] ?? ($anime['images']['jpg']['image_url'] ?? ''),
                    'badge' => $index === 0 ? 'TOP ANIME' : 'POPULAR ANIME',
                    'color' => $index === 0 ? 'bg-purple-600' : 'bg-pink-600',
                    'title' => $anime['title'] ?? 'Unknown Title',
                    'desc' => limitWords($anime['synopsis'] ?? 'No description available.', 25),
                    'rating' => $anime['score'] ?? 0,
                ];
            }
        }

        // Fallback jika API gagal/kosong
        if (empty($slides)) {
            $slides = [
                [
                    'img' => 'https://images.unsplash.com/photo-1616530940355-351fabd9524b?w=1920',
                    'badge' => 'NEW RELEASE',
                    'color' => 'bg-red-600',
                    'title' => 'The Dark Knight',
                    'desc' =>
                        'Ketika ancaman yang dikenal sebagai Joker muncul dari masa lalunya, Batman harus menghadapi ujian terbesar untuk memerangi ketidakadilan.',
                    'rating' => 9.0,
                ],
            ];
        }
    @endphp

    {{-- CAROUSEL CONTAINER --}}
    <div class="relative w-full h-[55vh] md:h-[65vh] overflow-hidden bg-black group" id="carousel-wrapper">

        {{-- SLIDES TRACK --}}
        <div class="flex h-full transition-transform duration-700 ease-in-out" id="track">
            @foreach ($slides as $index => $slide)
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

                            <p class="anim-item anim-desc text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                                {{ $slide['desc'] }}
                            </p>

                            {{-- Rating Badge --}}
                            @if (isset($slide['rating']) && $slide['rating'] > 0)
                                <div class="anim-item anim-desc flex items-center gap-2 mb-4">
                                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span
                                        class="text-white text-xl font-bold">{{ number_format($slide['rating'], 1) }}</span>
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
            track.style.transform = `translateX(-${curr * 100}%)`;

            slides.forEach((slide, idx) => {
                if (idx === curr) {
                    slide.classList.remove('is-active');
                    void slide.offsetWidth;
                    slide.classList.add('is-active');
                } else {
                    slide.classList.remove('is-active');
                }
            });

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

        let startX = 0;
        track.addEventListener('touchstart', e => startX = e.touches[0].clientX);
        track.addEventListener('touchend', e => {
            if (startX - e.changedTouches[0].clientX > 50) move(1);
            if (e.changedTouches[0].clientX - startX > 50) move(-1);
        });

        resetTimer();
    </script>

    {{-- MOVIE CARDS SECTION --}}
    <div class="container mx-auto px-8 md:px-16 py-12">

        {{-- MOVIES SECTION --}}
        @if (!empty($movies))
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="w-1 h-8 bg-red-600 rounded"></span>
                    Popular Movies
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach ($movies as $movie)
                        <div class="movie-card bg-gray-800 rounded-lg shadow-lg cursor-pointer">
                            {{-- Poster Image --}}
                            <div class="relative aspect-[2/3]">
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] ?? '' }}"
                                    alt="{{ $movie['title'] ?? 'Movie' }}"
                                    class="w-full h-full object-cover rounded-t-lg"
                                    onerror="this.src='https://via.placeholder.com/500x750?text=No+Image'">

                                {{-- Overlay on Hover --}}
                                <div class="movie-card-overlay rounded-t-lg">
                                    <div class="movie-card-content">
                                        <h3 class="text-white font-bold text-lg mb-2 line-clamp-2">
                                            {{ $movie['title'] ?? 'Unknown Title' }}
                                        </h3>

                                        {{-- Rating --}}
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-white font-semibold">
                                                {{ number_format($movie['vote_average'] ?? 0, 1) }}
                                            </span>
                                        </div>

                                        {{-- Synopsis --}}
                                        <p class="text-gray-300 text-sm mb-3 line-clamp-3">
                                            {{ $movie['overview'] ?? 'No synopsis available.' }}
                                        </p>

                                        {{-- Genre IDs (TMDB returns genre_ids, not full genre objects) --}}
                                        @if (!empty($movie['genre_ids']))
                                            <div class="flex flex-wrap gap-1">
                                                @php
                                                    // Map genre IDs to names (common TMDB genres)
                                                    $genreMap = [
                                                        28 => 'Action',
                                                        12 => 'Adventure',
                                                        16 => 'Animation',
                                                        35 => 'Comedy',
                                                        80 => 'Crime',
                                                        99 => 'Documentary',
                                                        18 => 'Drama',
                                                        10751 => 'Family',
                                                        14 => 'Fantasy',
                                                        36 => 'History',
                                                        27 => 'Horror',
                                                        10402 => 'Music',
                                                        9648 => 'Mystery',
                                                        10749 => 'Romance',
                                                        878 => 'Sci-Fi',
                                                        10770 => 'TV Movie',
                                                        53 => 'Thriller',
                                                        10752 => 'War',
                                                        37 => 'Western',
                                                    ];
                                                @endphp
                                                @foreach (array_slice($movie['genre_ids'], 0, 3) as $genreId)
                                                    <span class="px-2 py-1 bg-red-600/80 text-white text-xs rounded">
                                                        {{ $genreMap[$genreId] ?? 'Other' }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Title (Always Visible) --}}
                            <div class="p-3">
                                <h3 class="text-white font-semibold text-sm line-clamp-2">
                                    {{ $movie['title'] ?? 'Unknown Title' }}
                                </h3>
                                <p class="text-gray-400 text-xs mt-1">
                                    {{ isset($movie['release_date']) ? date('Y', strtotime($movie['release_date'])) : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ANIME SECTION --}}
        @if (!empty($animes))
            <div>
                <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                    <span class="w-1 h-8 bg-purple-600 rounded"></span>
                    Top Anime
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach ($animes as $anime)
                        <div class="movie-card bg-gray-800 rounded-lg shadow-lg cursor-pointer">
                            {{-- Poster Image --}}
                            <div class="relative aspect-[2/3]">
                                <img src="{{ $anime['images']['jpg']['large_image_url'] ?? ($anime['images']['jpg']['image_url'] ?? '') }}"
                                    alt="{{ $anime['title'] ?? 'Anime' }}"
                                    class="w-full h-full object-cover rounded-t-lg"
                                    onerror="this.src='https://via.placeholder.com/500x750?text=No+Image'">

                                {{-- Overlay on Hover --}}
                                <div class="movie-card-overlay rounded-t-lg">
                                    <div class="movie-card-content">
                                        <h3 class="text-white font-bold text-lg mb-2 line-clamp-2">
                                            {{ $anime['title'] ?? 'Unknown Title' }}
                                        </h3>

                                        {{-- Rating --}}
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-white font-semibold">
                                                {{ number_format($anime['score'] ?? 0, 1) }}
                                            </span>
                                        </div>

                                        {{-- Synopsis --}}
                                        <p class="text-gray-300 text-sm mb-3 line-clamp-3">
                                            {{ $anime['synopsis'] ?? 'No synopsis available.' }}
                                        </p>

                                        {{-- Genres --}}
                                        @if (!empty($anime['genres']))
                                            <div class="flex flex-wrap gap-1">
                                                @foreach (array_slice($anime['genres'], 0, 3) as $genre)
                                                    <span class="px-2 py-1 bg-purple-600/80 text-white text-xs rounded">
                                                        {{ $genre['name'] }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Title (Always Visible) --}}
                            <div class="p-3">
                                <h3 class="text-white font-semibold text-sm line-clamp-2">
                                    {{ $anime['title'] ?? 'Unknown Title' }}
                                </h3>
                                <p class="text-gray-400 text-xs mt-1">
                                    {{ $anime['year'] ?? 'N/A' }} • {{ $anime['episodes'] ?? '?' }} Episodes
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</body>

</html>
