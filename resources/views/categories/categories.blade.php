<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>All Categories - Movies, TV Series & Anime</title>
    <meta name="description" content="Browse all movie, TV series, and anime categories">

    <style>
        body {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: white;
            min-height: 100vh;
        }

        /* Smooth Loading Animation */
        .category-card {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animation delay */
        .category-card:nth-child(1) {
            animation-delay: 0.03s;
        }

        .category-card:nth-child(2) {
            animation-delay: 0.06s;
        }

        .category-card:nth-child(3) {
            animation-delay: 0.09s;
        }

        .category-card:nth-child(4) {
            animation-delay: 0.12s;
        }

        .category-card:nth-child(5) {
            animation-delay: 0.15s;
        }

        .category-card:nth-child(6) {
            animation-delay: 0.18s;
        }

        .category-card:nth-child(7) {
            animation-delay: 0.21s;
        }

        .category-card:nth-child(8) {
            animation-delay: 0.24s;
        }

        .category-card:nth-child(9) {
            animation-delay: 0.27s;
        }

        .category-card:nth-child(10) {
            animation-delay: 0.30s;
        }

        .category-card:nth-child(11) {
            animation-delay: 0.33s;
        }

        .category-card:nth-child(12) {
            animation-delay: 0.36s;
        }

        .category-card:nth-child(n+13) {
            animation-delay: 0.39s;
        }

        /* Hover effect glow */
        .category-card:hover {
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.4);
        }

        /* Search bar focus effect */
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.3);
        }
    </style>
</head>

<body>
    {{-- navbar --}}
    <x-navbar />
    {{-- end navbar --}}

    <div class="container mx-auto px-4 py-8 mt-20 max-w-7xl">
        {{-- Header Section --}}
        <div class="mb-12 text-center space-y-4">
            <h1
                class="text-5xl md:text-6xl font-extrabold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent pb-3">
                All Categories
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mt-2 mx-auto">
                Explore genres from movies, TV series, and anime all in one place
            </p>

            {{-- Search Bar --}}
            <div class="max-w-md mx-auto mt-8">
                <input type="text" id="searchInput" placeholder="Search categories..."
                    class="search-input w-full px-6 py-3 bg-slate-800 border border-slate-700 rounded-full text-white placeholder-gray-500 focus:outline-none focus:border-yellow-500 transition duration-300">
            </div>

            {{-- Stats --}}
            <div class="flex justify-center gap-8 mt-8 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-gray-400">Film & Anime</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-gray-400">Film Only</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-pink-500 rounded-full"></div>
                    <span class="text-gray-400">Anime Only</span>
                </div>
            </div>
        </div>

        {{-- Grid Categories --}}
        <div id="categoriesGrid"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @forelse ($genres as $genre)
                <a href="{{ route('categories.show', [
                    'name' => $genre['name'],
                    'tmdb_id' => $genre['tmdb_id'],
                    'jikan_id' => $genre['jikan_id'],
                ]) }}"
                    class="category-card block p-5 bg-slate-800/80 backdrop-blur-sm hover:bg-gradient-to-br hover:from-yellow-600 hover:to-orange-600 rounded-xl shadow-lg transition-all duration-300 group border-l-4 transform hover:scale-105
                   {{ $genre['tmdb_id'] && $genre['jikan_id'] ? 'border-green-500' : ($genre['tmdb_id'] ? 'border-blue-500' : 'border-pink-500') }}"
                    data-genre="{{ strtolower($genre['name']) }}">

                    <div class="flex flex-col h-full justify-between">
                        <div>
                            <span
                                class="text-base md:text-lg font-semibold group-hover:text-white line-clamp-2 leading-tight">
                                {{ $genre['name'] }}
                            </span>
                        </div>

                        {{-- Icon indicator --}}
                        <div class="mt-3 flex items-center justify-between">
                            <div class="text-xs text-gray-400 group-hover:text-gray-100 font-medium">
                                @if ($genre['tmdb_id'] && $genre['jikan_id'])
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                        </svg>
                                        All
                                    </span>
                                @elseif($genre['tmdb_id'])
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                                            <path
                                                d="M14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                        </svg>
                                        Film
                                    </span>
                                @else
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                        </svg>
                                        Anime
                                    </span>
                                @endif
                            </div>

                            <svg class="w-5 h-5 text-gray-500 group-hover:text-white transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-400 text-lg">No categories available at the moment</p>
                </div>
            @endforelse
        </div>

        {{-- No Results Message --}}
        <div id="noResults" class="hidden text-center py-16">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <p class="text-gray-400 text-lg">No categories found</p>
        </div>
    </div>

    {{-- Search Script --}}
    <script>
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.category-card');
            const grid = document.getElementById('categoriesGrid');
            const noResults = document.getElementById('noResults');
            let visibleCount = 0;

            cards.forEach(card => {
                const genreName = card.getAttribute('data-genre');
                if (genreName.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                grid.style.display = 'none';
                noResults.classList.remove('hidden');
            } else {
                grid.style.display = 'grid';
                noResults.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
