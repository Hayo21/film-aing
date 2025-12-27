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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border rounded-2xl p-4 border-gray-700/60">

                    {{-- Poster --}}
                    <div class="md:col-span-1 flex justify-center md:justify-start">
                        <div
                            class="w-[140px] sm:w-[160px] md:w-[180px] lg:w-[200px]
               aspect-[2/3] rounded-2xl overflow-hidden
               shadow-2xl border border-gray-700/60">
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

                {{-- Pemeran (Characters & Voice Actors) --}}
                @if (!empty($characters))
                    <section
                        class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 md:p-8 border border-gray-700/50 mt-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-red-600 rounded-full"></div>
                            <h2 class="text-2xl md:text-3xl font-bold">Karakter & Pengisi Suara</h2>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            {{-- Ambil 8 karakter pertama --}}
                            @foreach (array_slice($characters, 0, 8) as $char)
                                <div
                                    class="bg-gray-700/50 rounded-xl p-4 text-center hover:bg-gray-700 transition-colors duration-300">
                                    {{-- Foto Karakter --}}
                                    <div
                                        class="w-20 h-20 mx-auto rounded-full overflow-hidden mb-3 bg-gray-600 border-2 border-gray-500">
                                        @if (isset($char['character']['images']['jpg']['image_url']))
                                            <img src="{{ $char['character']['images']['jpg']['image_url'] }}"
                                                class="w-full h-full object-cover"
                                                alt="{{ $char['character']['name'] }}">
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

                                    {{-- Nama Karakter --}}
                                    <h4 class="font-bold text-sm mb-1 text-white truncate">
                                        <a href="{{ $char['character']['url'] ?? '#' }}" target="_blank"
                                            class="hover:text-purple-400">
                                            {{ $char['character']['name'] }}
                                        </a>
                                    </h4>

                                    {{-- Role (Main/Supporting) --}}
                                    <p class="text-xs text-gray-400 mb-2">{{ $char['role'] }}</p>

                                    {{-- Pengisi Suara (Japanese) --}}
                                    @php
                                        // Cari pengisi suara bahasa Jepang
                                        $va = collect($char['voice_actors'] ?? [])->firstWhere('language', 'Japanese');
                                    @endphp

                                    @if ($va)
                                        <div class="border-t border-gray-600 pt-2 mt-2">
                                            <p class="text-[10px] text-gray-500">Voice Actor</p>
                                            <p class="text-xs text-purple-300 truncate">{{ $va['person']['name'] }}</p>
                                        </div>
                                    @endif
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
