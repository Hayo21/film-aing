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
                <button
                    class="px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base font-semibold rounded-lg transition transform active:scale-95 md:hover:scale-105 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Diskusi Baru
                </button>
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="border-b border-gray-800 bg-slate-900/50 backdrop-blur-sm sticky top-0 md:top-16 z-10">
        <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16">
            <div class="flex gap-1 sm:gap-2 overflow-x-auto py-3 sm:py-4 tab-scroll">
                <button
                    class="px-4 sm:px-6 py-2 bg-red-600 text-white text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🔥 Trending
                </button>
                <button
                    class="px-4 sm:px-6 py-2 bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🎬 Movies
                </button>
                <button
                    class="px-4 sm:px-6 py-2 bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🎌 Anime
                </button>
                <button
                    class="px-4 sm:px-6 py-2 bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    ⭐ Terpopuler
                </button>
                <button
                    class="px-4 sm:px-6 py-2 bg-transparent hover:bg-slate-800 text-gray-400 hover:text-white text-sm sm:text-base font-semibold rounded-lg whitespace-nowrap transition flex-shrink-0">
                    🆕 Terbaru
                </button>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 py-6 sm:py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

            {{-- DISCUSSION LIST --}}
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                {{-- Featured Discussion --}}
                <div
                    class="discussion-card bg-gradient-to-br from-red-600/20 to-purple-600/20 border border-red-500/30 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                        <img src="https://image.tmdb.org/t/p/w500/8Gxv8gSFCU0XGDykEGv7zR1n2ua.jpg" alt="Poster"
                            class="w-20 h-28 sm:w-24 sm:h-36 object-cover rounded-lg shadow-lg flex-shrink-0">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <span
                                    class="badge-pulse px-2.5 sm:px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full">
                                    HOT 🔥
                                </span>
                                <span
                                    class="px-2.5 sm:px-3 py-1 bg-purple-600/30 text-purple-300 text-xs font-semibold rounded-full">
                                    Movie
                                </span>
                            </div>
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-bold text-white mb-2 hover:text-red-400 transition cursor-pointer line-clamp-2">
                                Review Oppenheimer: Masterpiece Biografi yang Memukau!
                            </h3>
                            <p class="text-sm sm:text-base text-gray-300 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-2">
                                Bahas tuntas kenapa Oppenheimer layak jadi best picture. Dari sinematografi, akting,
                                sampai historical accuracy-nya. Christopher Nolan memang nggak pernah mengecewakan...
                            </p>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-400">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-red-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            JD
                                        </div>
                                        <span class="hidden sm:inline">John Doe</span>
                                    </div>
                                    <span class="hidden sm:inline">•</span>
                                    <span>2 jam lalu</span>
                                </div>
                                <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                        </svg>
                                        <span class="font-semibold">234</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold">1.2k</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Regular Discussions --}}
                <div
                    class="discussion-card bg-slate-800/50 border border-gray-700 hover:border-red-500/50 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                        <img src="https://image.tmdb.org/t/p/w500/vZloFAK7NmvMGKE7VkF5UHaz0I.jpg" alt="Poster"
                            class="w-16 h-24 sm:w-20 sm:h-28 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="px-2.5 sm:px-3 py-1 bg-blue-600/30 text-blue-300 text-xs font-semibold rounded-full">
                                    Anime
                                </span>
                            </div>
                            <h3
                                class="text-base sm:text-lg md:text-xl font-bold text-white mb-2 hover:text-red-400 transition cursor-pointer line-clamp-2">
                                One Piece Episode Terbaru: Gear 5 Akhirnya Muncul!
                            </h3>
                            <p class="text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">
                                Episode kemarin benar-benar epic! Animasinya luar biasa, Toei Animation all out buat
                                adegan Gear 5 Luffy. Yang udah nonton, gimana menurut kalian?
                            </p>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
                                <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-400">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            AS
                                        </div>
                                        <span class="text-xs sm:text-sm">Anime Senpai</span>
                                    </div>
                                    <span class="hidden sm:inline">•</span>
                                    <span class="text-xs sm:text-sm">5 jam lalu</span>
                                </div>
                                <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                        </svg>
                                        <span class="font-semibold">156</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold">892</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="discussion-card bg-slate-800/50 border border-gray-700 hover:border-red-500/50 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                        <img src="https://image.tmdb.org/t/p/w500/qNBAXBIQlnOThrVvA6mA2B5ggV6.jpg" alt="Poster"
                            class="w-16 h-24 sm:w-20 sm:h-28 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="px-2.5 sm:px-3 py-1 bg-purple-600/30 text-purple-300 text-xs font-semibold rounded-full">
                                    Movie
                                </span>
                            </div>
                            <h3
                                class="text-base sm:text-lg md:text-xl font-bold text-white mb-2 hover:text-red-400 transition cursor-pointer line-clamp-2">
                                Dune Part 2: Worth the Wait atau Overhyped?
                            </h3>
                            <p class="text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">
                                Setelah nunggu lama akhirnya keluar juga. Menurut gw sih worth banget, tapi ada yang
                                bilang terlalu lambat. Share pendapat kalian dong!
                            </p>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
                                <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-400">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            MC
                                        </div>
                                        <span class="text-xs sm:text-sm">MovieCritic99</span>
                                    </div>
                                    <span class="hidden sm:inline">•</span>
                                    <span class="text-xs sm:text-sm">1 hari lalu</span>
                                </div>
                                <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                        </svg>
                                        <span class="font-semibold">89</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold">543</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="discussion-card bg-slate-800/50 border border-gray-700 hover:border-red-500/50 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                        <img src="https://image.tmdb.org/t/p/w500/rktDFPbfHfUbArZ6OOOKsXcv0Bm.jpg" alt="Poster"
                            class="w-16 h-24 sm:w-20 sm:h-28 object-cover rounded-lg flex-shrink-0">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="px-2.5 sm:px-3 py-1 bg-blue-600/30 text-blue-300 text-xs font-semibold rounded-full">
                                    Anime
                                </span>
                            </div>
                            <h3
                                class="text-base sm:text-lg md:text-xl font-bold text-white mb-2 hover:text-red-400 transition cursor-pointer line-clamp-2">
                                Attack on Titan Ending: Puas atau Kecewa?
                            </h3>
                            <p class="text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">
                                Setelah 10 tahun lebih, akhirnya AoT tamat. Ending-nya controversial banget sih. Ada
                                yang suka, ada yang benci. Kalian team mana?
                            </p>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
                                <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-400">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            EJ
                                        </div>
                                        <span class="text-xs sm:text-sm">ErenJaeger</span>
                                    </div>
                                    <span class="hidden sm:inline">•</span>
                                    <span class="text-xs sm:text-sm">3 hari lalu</span>
                                </div>
                                <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm">
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                        </svg>
                                        <span class="font-semibold">312</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-400">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold">2.1k</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Load More Button --}}
                <div class="text-center pt-4 sm:pt-6">
                    <button
                        class="w-full sm:w-auto px-6 sm:px-8 py-2.5 sm:py-3 bg-slate-800 hover:bg-slate-700 border border-gray-700 hover:border-red-500/50 text-white text-sm sm:text-base font-semibold rounded-lg transition">
                        Muat Lebih Banyak
                    </button>
                </div>

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
                        <div
                            class="flex items-center justify-between p-2.5 sm:p-3 bg-slate-700/30 rounded-lg hover:bg-slate-700/50 transition cursor-pointer">
                            <span class="text-gray-300 text-xs sm:text-sm">#OpenheimerReview</span>
                            <span class="text-red-400 text-xs font-bold">234</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-2.5 sm:p-3 bg-slate-700/30 rounded-lg hover:bg-slate-700/50 transition cursor-pointer">
                            <span class="text-gray-300 text-xs sm:text-sm">#OnePieceGear5</span>
                            <span class="text-red-400 text-xs font-bold">189</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-2.5 sm:p-3 bg-slate-700/30 rounded-lg hover:bg-slate-700/50 transition cursor-pointer">
                            <span class="text-gray-300 text-xs sm:text-sm">#DuneDiscussion</span>
                            <span class="text-red-400 text-xs font-bold">156</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-2.5 sm:p-3 bg-slate-700/30 rounded-lg hover:bg-slate-700/50 transition cursor-pointer">
                            <span class="text-gray-300 text-xs sm:text-sm">#MarvelVsDC</span>
                            <span class="text-red-400 text-xs font-bold">98</span>
                        </div>
                    </div>
                </div>

                {{-- Top Contributors --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h3 class="text-lg sm:text-xl font-bold text-white mb-3 sm:mb-4 flex items-center gap-2">
                        <span class="text-xl sm:text-2xl">⭐</span>
                        Top Contributors
                    </h3>
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="relative">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                                    JD
                                </div>
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-yellow-500 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-slate-900">
                                    1
                                </span>
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-semibold text-sm sm:text-base">John Doe</div>
                                <div class="text-gray-400 text-xs sm:text-sm">1,234 posts</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="relative">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                                    AS
                                </div>
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-gray-400 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-slate-900">
                                    2
                                </span>
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-semibold text-sm sm:text-base">Anime Senpai</div>
                                <div class="text-gray-400 text-xs sm:text-sm">987 posts</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="relative">
                                <div
                                    class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-amber-600 to-amber-700 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                                    MC
                                </div>
                                <span
                                    class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 bg-amber-600 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-slate-900">
                                    3
                                </span>
                            </div>
                            <div class="flex-1">
                                <div class="text-white font-semibold text-sm sm:text-base">MovieCritic99</div>
                                <div class="text-gray-400 text-xs sm:text-sm">756 posts</div>
                            </div>
                        </div>
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
