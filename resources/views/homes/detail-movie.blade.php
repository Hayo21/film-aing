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

                {{-- Movie Info --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border rounded-2xl p-4 border-gray-700/60">

                    {{-- Poster --}}
                    <div class="md:col-span-1 flex justify-center md:justify-start">
                        <div
                            class="w-[140px] sm:w-[160px] md:w-[180px] lg:w-[200px]
                                aspect-[2/3] rounded-2xl overflow-hidden
                                shadow-2xl border border-gray-700/60">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                class="w-full h-full object-cover" alt="{{ $movie['title'] }}">
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="md:col-span-2 space-y-6">

                        {{-- Title --}}
                        <div>
                            <h2 class="text-3xl font-bold mb-1">{{ $movie['title'] }}</h2>
                            @if (!empty($movie['tagline']))
                                <p class="text-gray-400 italic">"{{ $movie['tagline'] }}"</p>
                            @endif
                        </div>

                        {{-- Status & Language --}}
                        <div class="flex flex-wrap gap-2">
                            {{-- TYPE --}}
                            <span
                                class="px-4 py-1.5 bg-purple-600/30 text-purple-300 border border-purple-500/50 rounded-full text-sm">
                                Movie
                            </span>

                            {{-- STATUS --}}
                            <span
                                class="px-4 py-1.5 bg-red-600/30 text-red-300 border border-red-500/50 rounded-full text-sm">
                                {{ $movie['status'] }}
                            </span>

                            {{-- LANGUAGE --}}
                            <span
                                class="px-4 py-1.5 bg-blue-600/30 text-blue-300 border border-blue-500/50 rounded-full text-sm uppercase">
                                {{ $movie['original_language'] }}
                            </span>
                        </div>


                        {{-- Synopsis --}}
                        <div>
                            <h3 class="text-lg md:text-xl font-bold mb-2">Sinopsis</h3>
                            <p class="text-gray-300 leading-relaxed text-sm md:text-base text-justify">
                                {{ $movie['overview'] ?: 'Tidak ada sinopsis tersedia.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Trailer --}}
                @php
                    $trailer = collect($movie['videos']['results'] ?? [])->first(
                        fn($v) => $v['site'] === 'YouTube' && $v['type'] === 'Trailer',
                    );
                @endphp

                @if ($trailer)
                    <section class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-red-600 rounded-full"></div>
                            <h2 class="text-2xl font-bold">Trailer</h2>
                        </div>

                        <div class="aspect-video rounded-xl overflow-hidden">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $trailer['key'] }}"
                                allowfullscreen></iframe>
                        </div>
                    </section>
                @endif

                {{-- Cast --}}
                @if (!empty($movie['credits']['cast']))
                    <section class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 md:p-8 border border-gray-700/50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-red-600 rounded-full"></div>
                            <h2 class="text-2xl md:text-3xl font-bold">Pemeran Utama</h2>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach (array_slice($movie['credits']['cast'], 0, 8) as $cast)
                                <div class="bg-gray-700/50 rounded-xl p-4 text-center hover:bg-gray-700 transition">
                                    <div
                                        class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-3 bg-gray-600 border-2 border-gray-500">
                                        @if ($cast['profile_path'])
                                            <img src="https://image.tmdb.org/t/p/w200{{ $cast['profile_path'] }}"
                                                class="w-full h-full object-cover">
                                        @endif
                                    </div>

                                    <h4 class="font-bold text-sm mb-1">{{ $cast['name'] }}</h4>
                                    <p class="text-xs text-gray-400">{{ $cast['character'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="space-y-6">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Film
                    </h3>

                    <ul class="space-y-4">
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Release</span>
                            <span class="text-white font-medium">{{ $movie['release_date'] }}</span>
                        </li>
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Runtime</span>
                            <span class="text-white font-medium">{{ $movie['runtime'] }} menit</span>
                        </li>
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Budget</span>
                            <span class="text-white font-medium">
                                {{ $movie['budget'] ? '$' . number_format($movie['budget']) : '-' }}
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400 text-sm">Revenue</span>
                            <span class="text-white font-medium">
                                {{ $movie['revenue'] ? '$' . number_format($movie['revenue']) : '-' }}
                            </span>
                        </li>
                    </ul>

                    {{-- Genres --}}
                    @if (!empty($movie['genres']))
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <h4 class="text-gray-400 text-sm mb-3">Genres</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($movie['genres'] as $genre)
                                    <span
                                        class="px-3 py-1.5 bg-red-600/30 text-red-300 border border-red-500/50 rounded-full text-xs">
                                        {{ $genre['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</body>

</html>
