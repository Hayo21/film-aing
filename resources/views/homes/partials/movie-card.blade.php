{{-- resources/views/homes/partials/movie-card.blade.php --}}

@php
    // 1. Tentukan ID dan Route URL
    if ($type === 'movie') {
        $id = $item['id'] ?? 0;
        // Kita gunakan route() helper, pastikan route-nya sudah dibuat di web.php
        $url = route('movie.detail', $id);

        $image = 'https://image.tmdb.org/t/p/w500' . ($item['poster_path'] ?? '');
        $title = $item['title'] ?? 'Unknown Title';
        $rating = $item['vote_average'] ?? 0;
        $description = $item['overview'] ?? '';
        $year = isset($item['release_date']) ? date('Y', strtotime($item['release_date'])) : 'N/A';
        $genreIds = $item['genre_ids'] ?? [];
        $badgeColor = 'bg-red-600/80';

        $genreMap = App\Http\Controllers\HomeController::getGenreMap();
        $genres = array_map(fn($id) => $genreMap[$id] ?? 'Other', array_slice($genreIds, 0, 3));
    } else {
        // Anime (Jikan API pakai 'mal_id')
        $id = $item['mal_id'] ?? 0;
        $url = route('anime.detail', $id);

        $image = $item['images']['jpg']['large_image_url'] ?? ($item['images']['jpg']['image_url'] ?? '');
        $title = $item['title'] ?? 'Unknown Title';
        $rating = $item['score'] ?? 0;
        $description = $item['synopsis'] ?? '';
        $year = $item['year'] ?? 'N/A';
        $episodes = $item['episodes'] ?? '?';
        $badgeColor = 'bg-purple-600/80';

        $genreObjects = $item['genres'] ?? [];
        $genres = array_map(fn($g) => $g['name'], array_slice($genreObjects, 0, 3));
    }

    // Limit description
    $words = explode(' ', trim($description));
    $wordCount = count($words);

    if ($wordCount === 0 || empty($description)) {
        $shortDesc = 'Sinopsis tidak tersedia.';
    } elseif ($wordCount <= 15) {
        $shortDesc = $description;
    } else {
        $shortDesc = implode(' ', array_slice($words, 0, 15)) . '...';
    }
@endphp

{{-- 2. Bungkus Card dengan tag <a> --}}
<a href="{{ $url }}" class="block group h-full">
    <div
        class="movie-card bg-gray-800 rounded-lg shadow-lg cursor-pointer h-full flex flex-col transition-transform duration-300 group-hover:-translate-y-2">

        {{-- Poster Image Wrapper --}}
        <div class="relative aspect-[2/3] overflow-hidden rounded-t-lg">
            <img src="{{ $image }}" alt="{{ $title }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy"
                onerror="this.src='https://via.placeholder.com/500x750?text=No+Image'">

            {{-- Overlay on Hover --}}
            <div
                class="movie-card-overlay absolute inset-0 bg-gradient-to-t from-black via-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                <div
                    class="movie-card-content transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-white font-bold text-lg mb-2 line-clamp-2 leading-tight">
                        {{ $title }}
                    </h3>

                    {{-- Rating --}}
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-white font-semibold">{{ number_format((float) $rating, 1) }}</span>
                    </div>

                    {{-- Synopsis --}}
                    <p class="text-gray-300 text-xs mb-3 line-clamp-3">
                        {{ $shortDesc }}
                    </p>

                    {{-- Genres --}}
                    @if (!empty($genres))
                        <div class="flex flex-wrap gap-1">
                            @foreach ($genres as $genre)
                                <span class="px-2 py-1 {{ $badgeColor }} text-white text-[10px] rounded">
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
            <h3 class="text-white font-semibold text-sm line-clamp-2 group-hover:text-red-500 transition-colors">
                {{ $title }}
            </h3>
            <p class="text-gray-400 text-xs mt-1">
                @if ($type === 'movie')
                    {{ $year }}
                @else
                    {{ $year }} • {{ $episodes }} Eps
                @endif
            </p>
        </div>
    </div>
</a>
