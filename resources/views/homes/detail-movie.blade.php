<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $movie['title'] }} | Film Aing</title>
    <style>
        body {
            background-color: #0F172A;
            color: white;
            margin-top: 7vh;
        }
    </style>
</head>

<body>
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Movie Info Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border rounded-2xl p-4 border-gray-700/60">
                    {{-- Poster --}}
                    <div class="md:col-span-1 flex justify-center">
                        <div
                            class="w-[140px] sm:w-[160px] md:w-[180px] lg:w-[200px]
               aspect-[2/3] rounded-2xl overflow-hidden
               shadow-2xl border border-gray-700/60">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                class="w-full h-full object-cover" alt="{{ $movie['title'] }} Poster">
                        </div>
                    </div>

                    {{-- Movie Details --}}
                    <div class="md:col-span-2 space-y-6">
                        {{-- Title --}}
                        <div>
                            <h2 class="text-3xl font-bold mb-2">{{ $movie['title'] }}</h2>
                            @if ($movie['tagline'])
                                <p class="text-gray-400 italic">"{{ $movie['tagline'] }}"</p>
                            @endif
                        </div>

                        {{-- Genres --}}
                        <div class="flex flex-wrap gap-2">
                            @foreach ($movie['genres'] as $genre)
                                <span
                                    class="px-4 py-1.5 bg-red-600/30 text-red-300 border border-red-500/50 rounded-full text-sm font-medium">
                                    {{ $genre['name'] }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Synopsis --}}
                        <div>
                            <h3 class="text-lg md:text-xl font-bold mb-2 md:mb-3">Sinopsis</h3>
                            <p class="text-gray-300 leading-relaxed text-sm md:text-base text-justify">
                                {{ $movie['overview'] ?: 'Tidak ada sinopsis tersedia.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Trailer --}}
                @php
                    $trailer = null;

                    if (!empty($movie['videos']['results'])) {
                        foreach ($movie['videos']['results'] as $video) {
                            if ($video['site'] === 'YouTube' && $video['type'] === 'Trailer') {
                                $trailer = $video;
                                break;
                            }
                        }
                    }
                @endphp

                @if ($trailer)
                    <section class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-red-600 rounded-full"></div>
                            <h2 class="text-2xl font-bold">Trailer</h2>
                        </div>

                        <div class="aspect-video rounded-xl overflow-hidden">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $trailer['key'] }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </section>
                @endif

                {{-- Cast --}}
                @if (isset($movie['credits']['cast']) && count($movie['credits']['cast']) > 0)
                    <section class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 md:p-8 border border-gray-700/50 ">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-red-600 rounded-full"></div>
                            <h2 class="text-2xl md:text-3xl font-bold">Pemeran Utama</h2>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach (array_slice($movie['credits']['cast'], 0, 8) as $cast)
                                <div
                                    class="bg-gray-700/50 rounded-xl p-4 text-center hover:bg-gray-700 transition-colors duration-300">
                                    <div
                                        class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-3 bg-gray-600 border-2 border-gray-500">
                                        @if ($cast['profile_path'])
                                            <img src="https://image.tmdb.org/t/p/w200{{ $cast['profile_path'] }}"
                                                class="w-full h-full object-cover" alt="{{ $cast['name'] }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-sm mb-1 text-white">{{ $cast['name'] }}</h4>
                                    <p class="text-xs text-gray-400 line-clamp-2">{{ $cast['character'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="space-y-6">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 ">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Film
                    </h3>

                    <ul class="space-y-4">
                        <li class="flex justify-between items-center pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Status</span>
                            <span class="text-white font-medium">{{ $movie['status'] }}</span>
                        </li>
                        <li class="flex justify-between items-center pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Budget</span>
                            <span class="text-white font-medium">
                                @if ($movie['budget'] > 0)
                                    ${{ number_format($movie['budget']) }}
                                @else
                                    -
                                @endif
                            </span>
                        </li>
                        <li class="flex justify-between items-center pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Revenue</span>
                            <span class="text-white font-medium">
                                @if ($movie['revenue'] > 0)
                                    ${{ number_format($movie['revenue']) }}
                                @else
                                    -
                                @endif
                            </span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">Bahasa Asli</span>
                            <span class="text-white font-medium uppercase">{{ $movie['original_language'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</body>

</html>
