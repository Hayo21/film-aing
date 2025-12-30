<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
    <title>{{ $genreName }} Category | Film Aing</title>

    <style>
        body {
            background-color: #0F172A;
        }

        /* === CARD HOVER EFFECTS (sama seperti home) === */
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
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.8), transparent);
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

        /* === PAGE HEADER ANIMATION === */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            animation: fadeInDown 0.6s ease-out;
        }

        /* === CARD LOADING ANIMATION === */
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

        .movie-card {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</head>

<body>

    <x-navbar />


    {{-- PAGE HEADER --}}
    <div
        class="relative w-full
           pt-[110px] md:pt-[140px]
           h-[30vh] md:h-[40vh]
           bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.1),transparent_50%)]">
            </div>
        </div>
        <div class="relative container mx-auto px-8 md:px-16 h-full flex items-center">
            <div class="page-header">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-1 h-12 bg-yellow-500 rounded"></span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                        {{ $genreName }}
                    </h1>
                </div>
                <p class="text-gray-400 text-lg md:text-xl">
                    Mixed Collection: Movies, TV Series & Anime
                </p>
            </div>
        </div>
    </div>

    {{-- CONTENT SECTIONS --}}
    <div class="container mx-auto px-8 md:px-16 py-12">

        @if (!empty($content) && count($content) > 0)
            <section class="mb-12">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">

                    @foreach ($content as $item)
                        @php
                            // === GENRE MAP untuk TMDB ===
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
                                878 => 'Science Fiction',
                                10770 => 'TV Movie',
                                53 => 'Thriller',
                                10752 => 'War',
                                37 => 'Western',
                                10759 => 'Action & Adventure',
                                10762 => 'Kids',
                                10763 => 'News',
                                10764 => 'Reality',
                                10765 => 'Sci-Fi & Fantasy',
                                10766 => 'Soap',
                                10767 => 'Talk',
                                10768 => 'War & Politics',
                            ];

                            // === LOGIKA UNTUK MENENTUKAN DATA BERDASARKAN TIPE ===
                            $type = $item['media_type'] ?? 'movie';
                            $id = $item['id'] ?? ($item['mal_id'] ?? 0);
                            $rating = $item['vote_average'] ?? ($item['score'] ?? 0);

                            // Default Values
                            $title = 'Unknown';
                            $image = '';
                            $year = 'N/A';
                            $overview = '';
                            $hoverColor = 'text-white';
                            $badgeColor = 'bg-gray-600';
                            $genres = [];
                            $detailUrl = '#'; // Default URL

                            // 1. Jika MOVIE
                            if ($type === 'movie') {
                                $title = $item['title'] ?? 'Unknown Movie';
                                $image = 'https://image.tmdb.org/t/p/w500' . ($item['poster_path'] ?? '');
                                $year = isset($item['release_date'])
                                    ? date('Y', strtotime($item['release_date']))
                                    : 'N/A';
                                $overview = $item['overview'] ?? '';
                                $hoverColor = 'group-hover:text-red-500';
                                $badgeColor = 'bg-red-600/80';
                                $detailUrl = route('homes.detail-movie', ['id' => $id]);

                                // Get genres dari genre_ids
                                $genreIds = $item['genre_ids'] ?? [];
                                $genres = array_map(
                                    fn($gid) => $genreMap[$gid] ?? 'Other',
                                    array_slice($genreIds, 0, 3),
                                );
                            }
                            // 2. Jika TV
                            elseif ($type === 'tv') {
                                $title = $item['name'] ?? 'Unknown TV';
                                $image = 'https://image.tmdb.org/t/p/w500' . ($item['poster_path'] ?? '');
                                $year = isset($item['first_air_date'])
                                    ? date('Y', strtotime($item['first_air_date']))
                                    : 'N/A';
                                $overview = $item['overview'] ?? '';
                                $hoverColor = 'group-hover:text-blue-500';
                                $badgeColor = 'bg-blue-600/80';
                                // Jika Anda punya route untuk TV series detail, ganti dengan route yang sesuai
                                $detailUrl = route('homes.detail-movie', ['id' => $id]); // atau route khusus TV

                                // Get genres dari genre_ids
                                $genreIds = $item['genre_ids'] ?? [];
                                $genres = array_map(
                                    fn($gid) => $genreMap[$gid] ?? 'Other',
                                    array_slice($genreIds, 0, 3),
                                );
                            }
                            // 3. Jika ANIME
                            elseif ($type === 'anime') {
                                $title = $item['title'] ?? 'Unknown Anime';
                                $image =
                                    $item['images']['jpg']['large_image_url'] ??
                                    ($item['images']['jpg']['image_url'] ?? '');
                                $year = $item['year'] ?? 'N/A';
                                $overview = $item['synopsis'] ?? '';
                                $hoverColor = 'group-hover:text-purple-500';
                                $badgeColor = 'bg-purple-600/80';
                                $detailUrl = route('homes.detail-anime', ['id' => $id]);

                                // Get genres dari genres array (Jikan API)
                                $genreObjects = $item['genres'] ?? [];
                                $genres = array_map(fn($g) => $g['name'], array_slice($genreObjects, 0, 3));
                            }

                            // Limit overview untuk synopsis
                            $words = explode(' ', trim($overview));
                            $wordCount = count($words);
                            if ($wordCount === 0 || empty($overview)) {
                                $shortDesc = 'Sinopsis tidak tersedia.';
                            } elseif ($wordCount <= 15) {
                                $shortDesc = $overview;
                            } else {
                                $shortDesc = implode(' ', array_slice($words, 0, 15)) . '...';
                            }
                        @endphp

                        {{-- Wrap card dengan link --}}
                        <a href="{{ $detailUrl }}" class="block">
                            <div
                                class="movie-card bg-gray-800 rounded-lg shadow-lg cursor-pointer h-full flex flex-col group relative">

                                {{-- Badge Tipe Media --}}
                                <div class="absolute top-2 right-2 z-10">
                                    <span
                                        class="text-[10px] font-bold text-white px-2 py-0.5 rounded shadow-sm {{ $badgeColor }}">
                                        {{ strtoupper($type) }}
                                    </span>
                                </div>

                                {{-- Poster Image --}}
                                <div class="relative aspect-[2/3] overflow-hidden rounded-t-lg bg-gray-900">
                                    <img src="{{ $image }}" alt="{{ $title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        loading="lazy"
                                        onerror="this.src='https://via.placeholder.com/500x750?text=No+Image'">

                                    {{-- Overlay on Hover --}}
                                    <div class="movie-card-overlay">
                                        <div class="movie-card-content">
                                            <h3 class="text-white font-bold text-lg mb-2 line-clamp-2 leading-tight">
                                                {{ $title }}
                                            </h3>

                                            {{-- Rating --}}
                                            @if ($rating > 0)
                                                <div class="flex items-center gap-2 mb-2">
                                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    <span
                                                        class="text-white font-semibold">{{ number_format($rating, 1) }}</span>
                                                </div>
                                            @endif

                                            {{-- Synopsis --}}
                                            <p class="text-gray-300 text-xs mb-3 line-clamp-3">
                                                {{ $shortDesc }}
                                            </p>

                                            {{-- Genres / Categories --}}
                                            @if (!empty($genres))
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($genres as $genre)
                                                        <span
                                                            class="px-2 py-1 {{ $badgeColor }} text-white text-[10px] rounded">
                                                            {{ $genre }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Title (Always Visible) --}}
                                <div class="p-3 flex-grow bg-gray-900 rounded-b-lg">
                                    <h3
                                        class="text-white font-semibold text-sm line-clamp-2 {{ $hoverColor }} transition-colors">
                                        {{ $title }}
                                    </h3>
                                    <p class="text-gray-400 text-xs mt-1">{{ $year }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @else
            {{-- EMPTY STATE --}}
            <div class="text-center py-20">
                <div class="text-6xl mb-4">🎬</div>
                <h3 class="text-2xl font-bold text-white mb-2">No Content Found</h3>
                <p class="text-gray-400">There's no content available in this category yet.</p>
                <a href="{{ route('categories.index') }}"
                    class="inline-block mt-6 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    Browse All Categories
                </a>
            </div>
        @endif

    </div>

</body>

</html>
