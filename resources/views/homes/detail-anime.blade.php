<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $anime['title'] }} | Film Aing</title>
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

                {{-- Anime Info Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 border rounded-2xl p-4 border-gray-700/60">

                    {{-- Poster --}}
                    <div class="flex justify-center">
                        <div
                            class="w-[150px] md:w-[180px] aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl border border-gray-700/60">
                            <img src="{{ $anime['images']['jpg']['large_image_url'] }}"
                                class="w-full h-full object-cover" alt="{{ $anime['title'] }} Poster">
                        </div>
                    </div>

                    {{-- Anime Details --}}
                    <div class="md:col-span-2 space-y-6">

                        {{-- Title --}}
                        <div>
                            <h2 class="text-3xl font-bold mb-1">{{ $anime['title'] }}</h2>
                            @if (!empty($anime['title_japanese']))
                                <p class="text-gray-400 italic">{{ $anime['title_japanese'] }}</p>
                            @endif
                        </div>

                        {{-- Type & Status --}}
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="px-4 py-1.5 bg-purple-600/30 text-purple-300 border border-purple-500/50 rounded-full text-sm">
                                {{ $anime['type'] }}
                            </span>
                            <span
                                class="px-4 py-1.5 bg-blue-600/30 text-blue-300 border border-blue-500/50 rounded-full text-sm">
                                {{ $anime['status'] }}
                            </span>
                        </div>

                        {{-- Synopsis --}}
                        <div>
                            <h3 class="text-lg md:text-xl font-bold mb-2">Sinopsis</h3>
                            <p class="text-gray-300 leading-relaxed text-sm md:text-base text-justify">
                                {{ $anime['synopsis'] ?: 'Tidak ada sinopsis tersedia.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Trailer --}}
                @if (!empty($anime['trailer']['embed_url']))
                    <section class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-purple-600 rounded-full"></div>
                            <h2 class="text-2xl font-bold">Trailer</h2>
                        </div>

                        <div class="aspect-video rounded-xl overflow-hidden">
                            <iframe class="w-full h-full"
                                src="{{ str_replace('autoplay=1', 'autoplay=0', $anime['trailer']['embed_url']) }}"
                                allowfullscreen></iframe>
                        </div>
                    </section>
                @endif
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="space-y-6">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 sticky top-4">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Anime
                    </h3>

                    <ul class="space-y-4">
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Score</span>
                            <span class="text-yellow-400 font-bold">{{ $anime['score'] }}/10</span>
                        </li>
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Episodes</span>
                            <span class="text-white font-medium">{{ $anime['episodes'] ?? '?' }}</span>
                        </li>
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Duration</span>
                            <span class="text-white font-medium">{{ $anime['duration'] }}</span>
                        </li>
                        <li class="flex justify-between pb-4 border-b border-gray-700">
                            <span class="text-gray-400 text-sm">Season</span>
                            <span class="text-white font-medium capitalize">
                                {{ $anime['season'] ?? '-' }} {{ $anime['year'] ?? '' }}
                            </span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-400 text-sm">Rating</span>
                            <span class="text-white font-medium">{{ $anime['rating'] }}</span>
                        </li>
                    </ul>

                    {{-- Genres --}}
                    @if (!empty($anime['genres']))
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <h4 class="text-gray-400 text-sm mb-3">Genres</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($anime['genres'] as $genre)
                                    <span
                                        class="px-3 py-1.5 bg-purple-600/30 text-purple-300 border border-purple-500/50 rounded-full text-xs">
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
