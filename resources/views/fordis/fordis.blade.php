<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>FORDIS - Forum Diskusi | Film Aing</title>

    <style>
        body {
            background-color: #0F172A;
            margin-top: 8vh;
        }

        /* Card Hover Effects */
        .discussion-card {
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            .discussion-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2);
            }
        }

        /* Badge Animations */
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Mobile Optimization */
        @media (max-width: 767px) {
            .discussion-card {
                touch-action: manipulation;
            }

            /* Hide scrollbar on mobile for tabs */
            .tab-scroll::-webkit-scrollbar {
                display: none;
            }

            .tab-scroll {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        }
    </style>
</head>

<body>

    <x-navbar />

    {{-- HERO SECTION --}}
    <div
        class="relative w-full h-[35vh] sm:h-[40vh] md:h-[45vh] bg-gradient-to-br from-slate-900 via-purple-900/20 to-slate-900 overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNnoiIHN0cm9rZT0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvZz48L3N2Zz4=')] opacity-40">
        </div>

        <div class="relative container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 h-full flex flex-col justify-center">
            <div class="max-w-3xl">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-red-600/20 border border-red-500/30 text-red-400 text-xs sm:text-sm font-semibold rounded-full mb-3 sm:mb-4 backdrop-blur-sm">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                        <path
                            d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                    </svg>
                    Forum Diskusi
                </span>
                <h1
                    class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold text-white mb-2 sm:mb-3 md:mb-4 leading-tight">
                    Ngaloco Bareng<br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-purple-500">
                        Pecinta Film & Anime
                    </span>
                </h1>
                <p class="text-sm sm:text-base md:text-lg text-gray-300 mb-4 sm:mb-6">
                    Ngaloco film & anime favorit, share review, dan temukan rekomendasi dari komunitas
                </p>

                {{-- LOGIC TOMBOL BUAT DISKUSI --}}
                @auth
                    <a href="{{ route('fordis.create') }}"
                        class="inline-flex px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base font-semibold rounded-lg transition transform active:scale-95 md:hover:scale-105 items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Diskusi Baru
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base font-semibold rounded-lg transition transform active:scale-95 md:hover:scale-105 items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login untuk Diskusi
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="border-b border-gray-800 bg-slate-900/50 backdrop-blur-sm sticky top-0 md:top-16 z-10">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16">
            <div class="flex gap-1 sm:gap-2 overflow-x-auto py-3 sm:py-4 tab-scroll">
                <a href="{{ route('fordis', ['filter' => 'trending']) }}"
                    class="px-4 sm:px-6 py-2 {{ ($filter ?? 'trending') == 'trending' ? 'bg-red-600 text-white' : 'bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white' }} text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🔥 Trending
                </a>
                <a href="{{ route('fordis', ['filter' => 'movies']) }}"
                    class="px-4 sm:px-6 py-2 {{ ($filter ?? '') == 'movies' ? 'bg-red-600 text-white' : 'bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white' }} text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🎬 Movies
                </a>
                <a href="{{ route('fordis', ['filter' => 'anime']) }}"
                    class="px-4 sm:px-6 py-2 {{ ($filter ?? '') == 'anime' ? 'bg-red-600 text-white' : 'bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white' }} text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🎌 Anime
                </a>
                <a href="{{ route('fordis', ['filter' => 'popular']) }}"
                    class="px-4 sm:px-6 py-2 {{ ($filter ?? '') == 'popular' ? 'bg-red-600 text-white' : 'bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white' }} text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    ⭐ Terpopuler
                </a>
                <a href="{{ route('fordis', ['filter' => 'latest']) }}"
                    class="px-4 sm:px-6 py-2 {{ ($filter ?? '') == 'latest' ? 'bg-red-600 text-white' : 'bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white' }} text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🆕 Terbaru
                </a>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 py-6 sm:py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

            {{-- DISCUSSION LIST --}}
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                {{-- LOOP DISKUSI DARI DATABASE --}}
                @forelse($discussions as $discussion)
                    <div
                        class="discussion-card {{ $discussion->is_featured ? 'bg-gradient-to-br from-red-600/20 to-purple-600/20 border border-red-500/30' : 'bg-slate-800/50 border border-gray-700 hover:border-red-500/50' }} rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                        <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                            @if ($discussion->media_poster)
                                <img src="{{ $discussion->media_poster }}" alt="Poster"
                                    class="w-20 h-28 sm:w-24 sm:h-36 object-cover rounded-lg shadow-lg flex-shrink-0">
                            @endif
                            <div class="flex-1 w-full">
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    @if ($discussion->is_featured)
                                        <span
                                            class="badge-pulse px-2.5 sm:px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full">
                                            HOT 🔥
                                        </span>
                                    @endif
                                    <span
                                        class="px-2.5 sm:px-3 py-1 {{ $discussion->media_type == 'anime' ? 'bg-blue-600/30 text-blue-300' : 'bg-purple-600/30 text-purple-300' }} text-xs font-semibold rounded-full">
                                        {{ $discussion->media_type == 'anime' ? 'Anime' : 'Movie' }}
                                    </span>
                                </div>
                                <a href="{{ route('fordis.show', $discussion->id) }}">
                                    <h3
                                        class="text-lg sm:text-xl md:text-2xl font-bold text-white mb-2 hover:text-red-400 transition cursor-pointer line-clamp-2">
                                        {{ $discussion->title }}
                                    </h3>
                                </a>
                                <p class="text-sm sm:text-base text-gray-300 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-2">
                                    {{ Str::limit($discussion->content, 150) }}
                                </p>
                                <div
                                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                    <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-400">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-red-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                                {{ strtoupper(substr($discussion->user->name, 0, 2)) }}
                                            </div>
                                            <span class="hidden sm:inline">{{ $discussion->user->name }}</span>
                                        </div>
                                        <span class="hidden sm:inline">•</span>
                                        <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                    </div>

                                    {{-- ACTION BUTTONS (LIKE & COMMENT) DENGAN LOGIKA AUTH --}}
                                    <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm">

                                        {{-- Tombol Like --}}
                                        @auth
                                            <form action="{{ route('fordis.like', $discussion->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <input type="hidden" name="is_like" value="1">
                                                <button type="submit"
                                                    class="flex items-center gap-1 {{ $discussion->isLikedBy(auth()->id()) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }} transition">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5"
                                                        fill="{{ $discussion->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                    <span class="font-semibold">{{ $discussion->likesCount() }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="flex items-center gap-1 text-gray-400 hover:text-red-500 transition"
                                                title="Login untuk menyukai">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                                <span class="font-semibold">{{ $discussion->likesCount() }}</span>
                                            </a>
                                        @endauth

                                        {{-- Tombol Komentar --}}
                                        <a href="{{ route('fordis.show', $discussion->id) }}"
                                            class="flex items-center gap-1 text-gray-400 hover:text-blue-500 transition">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                            </svg>
                                            <span class="font-semibold">{{ $discussion->commentsCount() }}</span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-12 bg-slate-800/50 border border-gray-700 rounded-xl">
                        <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-gray-400 text-lg mb-4">Belum ada diskusi. Jadilah yang pertama!</p>
                        @auth
                            <a href="{{ route('fordis.create') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Buat Diskusi Pertama
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                Login untuk Memulai
                            </a>
                        @endauth
                    </div>
                @endforelse

                {{-- Pagination --}}
                @if ($discussions->hasPages())
                    <div class="mt-6">
                        {{ $discussions->links() }}
                    </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- Trending Topics --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-3 sm:mb-4 flex items-center gap-2">
                        <span class="text-xl sm:text-2xl">🔥</span>
                        Trending Topics
                    </h3>
                    <div class="space-y-2 sm:space-y-3">
                        @forelse($trendingTopics ?? [] as $topic)
                            <div
                                class="flex items-center justify-between p-2.5 sm:p-3 bg-slate-700/30 rounded-lg hover:bg-slate-700/50 transition cursor-pointer">
                                <span class="text-gray-300 text-xs sm:text-sm">#{{ ucfirst($topic->category) }}</span>
                                <span class="text-red-400 text-xs font-bold">{{ $topic->count }}</span>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">Belum ada trending topics</p>
                        @endforelse
                    </div>
                </div>

                {{-- Top Contributors --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-3 sm:mb-4 flex items-center gap-2">
                        <span class="text-xl sm:text-2xl">⭐</span>
                        Top Contributors
                    </h3>
                    <div class="space-y-3 sm:space-y-4">
                        @php
                            $topUsers = \App\Models\User::withCount('discussions')
                                ->orderBy('discussions_count', 'desc')
                                ->take(3)
                                ->get();
                        @endphp

                        @forelse($topUsers as $index => $user)
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="relative">
                                    <div
                                        class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br {{ $index == 0 ? 'from-yellow-500 to-orange-500' : ($index == 1 ? 'from-gray-400 to-gray-500' : 'from-amber-600 to-amber-700') }} rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span
                                        class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 {{ $index == 0 ? 'bg-yellow-500' : ($index == 1 ? 'bg-gray-400' : 'bg-amber-600') }} text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-slate-900">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="text-white font-semibold text-sm sm:text-base">{{ $user->name }}
                                    </div>
                                    <div class="text-gray-400 text-xs sm:text-sm">{{ $user->discussions_count }} posts
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">Belum ada kontributor</p>
                        @endforelse
                    </div>
                </div>

                {{-- Forum Rules --}}
                <div
                    class="bg-gradient-to-br from-red-600/20 to-purple-600/20 border border-red-500/30 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-3 sm:mb-4 flex items-center gap-2">
                        <span class="text-xl sm:text-2xl">📜</span>
                        Aturan Forum
                    </h3>
                    <ul class="space-y-2 text-gray-300 text-xs sm:text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-1">•</span>
                            <span>Hormati pendapat orang lain</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-1">•</span>
                            <span>No spoiler tanpa warning</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-1">•</span>
                            <span>Gunakan bahasa yang sopan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-1">•</span>
                            <span>Dilarang spam dan iklan</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

</body>

</html>
