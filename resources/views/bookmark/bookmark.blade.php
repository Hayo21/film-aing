<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>My Bookmarks | Film Aing</title>
    <style>
        body {
            background-color: #0F172A;
            color: white;
            margin-top: 8vh;
        }

        .bookmark-card {
            transition: all 0.3s ease;
        }

        .bookmark-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2);
        }
    </style>
</head>

<body>
    <x-navbar />

    {{-- HERO SECTION --}}
    <div class="relative w-full h-[30vh] bg-gradient-to-br from-slate-900 via-red-900/20 to-slate-900 overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNnoiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvZz48L3N2Zz4=')] opacity-40">
        </div>

        <div class="relative container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 h-full flex flex-col justify-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600/20 border border-red-500/30 text-red-400 text-sm font-semibold rounded-full mb-4 w-fit backdrop-blur-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                </svg>
                My Bookmarks
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-3 leading-tight">
                Koleksi Favoritmu
            </h1>
            <p class="text-gray-300 text-base sm:text-lg max-w-2xl">
                Film & Anime yang kamu simpan untuk ditonton nanti
            </p>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 py-8 md:py-12">

        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-600/20 border border-green-500/50 rounded-lg text-green-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter Tabs --}}
        <div class="mb-8 flex gap-3 overflow-x-auto pb-2">
            <button onclick="filterBookmarks('all')"
                class="filter-btn active px-6 py-2 bg-red-600 text-white font-semibold rounded-lg whitespace-nowrap transition">
                Semua ({{ $bookmarks->count() }})
            </button>
            <button onclick="filterBookmarks('movie')"
                class="filter-btn px-6 py-2 bg-slate-800 hover:bg-slate-700 text-gray-300 hover:text-white font-semibold rounded-lg whitespace-nowrap transition">
                🎬 Movies ({{ $bookmarks->where('media_type', 'movie')->count() }})
            </button>
            <button onclick="filterBookmarks('anime')"
                class="filter-btn px-6 py-2 bg-slate-800 hover:bg-slate-700 text-gray-300 hover:text-white font-semibold rounded-lg whitespace-nowrap transition">
                🎌 Anime ({{ $bookmarks->where('media_type', 'anime')->count() }})
            </button>
        </div>

        {{-- Bookmarks Grid --}}
        @if ($bookmarks->isEmpty())
            <div class="text-center py-20 bg-slate-800/50 border border-gray-700 rounded-2xl">
                <svg class="w-24 h-24 mx-auto text-gray-600 mb-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <h3 class="text-2xl font-bold text-white mb-3">Belum Ada Bookmark</h3>
                <p class="text-gray-400 mb-6">Mulai simpan film & anime favorit kamu!</p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Jelajahi Film & Anime
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
                @foreach ($bookmarks as $bookmark)
                    <div class="bookmark-card bg-slate-800/50 border border-gray-700 rounded-xl overflow-hidden backdrop-blur-sm"
                        data-type="{{ $bookmark->media_type }}">
                        {{-- Poster --}}
                        <div class="relative aspect-[2/3] group">
                            <img src="{{ $bookmark->poster_url }}" alt="{{ $bookmark->title }}"
                                class="w-full h-full object-cover">

                            {{-- Overlay on Hover --}}
                            <div
                                class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-3 p-4">
                                {{-- View Button --}}
                                <a href="{{ $bookmark->media_type === 'movie' ? route('movie.detail', $bookmark->media_id) : route('anime.detail', $bookmark->media_id) }}"
                                    class="px-4 py-2 bg-white hover:bg-gray-200 text-gray-900 font-semibold rounded-lg transition text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </a>

                                {{-- Remove Button --}}
                                <form action="{{ route('bookmark.destroy', $bookmark->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus dari bookmark?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>

                            {{-- Badge Type --}}
                            <div class="absolute top-2 right-2">
                                <span
                                    class="px-2 py-1 {{ $bookmark->media_type === 'anime' ? 'bg-blue-600' : 'bg-purple-600' }} text-white text-xs font-bold rounded-md">
                                    {{ $bookmark->media_type === 'anime' ? 'ANIME' : 'MOVIE' }}
                                </span>
                            </div>

                            {{-- Rating Badge --}}
                            @if ($bookmark->rating)
                                <div class="absolute top-2 left-2">
                                    <span
                                        class="px-2 py-1 bg-yellow-600 text-white text-xs font-bold rounded-md flex items-center gap-1">
                                        ⭐ {{ number_format($bookmark->rating, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-3">
                            <h3 class="text-white font-semibold text-sm line-clamp-2 mb-1">
                                {{ $bookmark->title }}
                            </h3>
                            @if ($bookmark->release_date)
                                <p class="text-gray-400 text-xs">
                                    {{ \Carbon\Carbon::parse($bookmark->release_date)->format('Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <script>
        function filterBookmarks(type) {
            const cards = document.querySelectorAll('.bookmark-card');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update button styles
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-red-600', 'text-white');
                btn.classList.add('bg-slate-800', 'text-gray-300');
            });
            event.target.classList.remove('bg-slate-800', 'text-gray-300');
            event.target.classList.add('active', 'bg-red-600', 'text-white');

            // Filter cards
            cards.forEach(card => {
                if (type === 'all' || card.dataset.type === type) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

</body>

</html>
