<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $discussion->title }} - FORDIS | Film Aing</title>

    <style>
        body {
            background-color: #0F172A;
            margin-top: 8vh;
        }

        /* Nested Comments Indentation */
        .reply-indent {
            margin-left: 0.75rem;
            padding-left: 0.75rem;
            border-left: 2px solid rgba(239, 68, 68, 0.3);
        }

        @media (min-width: 640px) {
            .reply-indent {
                margin-left: 1.5rem;
                padding-left: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .reply-indent {
                margin-left: 2.5rem;
                padding-left: 2rem;
            }
        }

        /* Reply Form Animation */
        .reply-form {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Image Optimization */
        .poster-image {
            max-height: 150px;
            object-fit: contain;
        }

        @media (min-width: 640px) {
            .poster-image {
                max-height: 150px;
            }
        }
    </style>
</head>

<body>
    <x-navbar />

    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 py-4 sm:py-6 md:py-8">

        {{-- Breadcrumb / Back Button --}}
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('fordis') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800/50 hover:bg-slate-700 border border-gray-700 hover:border-red-500/50 text-gray-300 hover:text-white rounded-lg transition-all duration-300 group">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 transform group-hover:-translate-x-1 transition-transform"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm sm:text-base font-semibold">Kembali ke Forum</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                {{-- Discussion Detail --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm">

                    {{-- Header Badges --}}
                    <div class="flex items-center gap-2 mb-3 sm:mb-4 flex-wrap">
                        <span
                            class="px-2.5 sm:px-3 py-1 {{ $discussion->media_type == 'anime' ? 'bg-blue-600/30 text-blue-300 border border-blue-500/30' : 'bg-purple-600/30 text-purple-300 border border-purple-500/30' }} text-xs font-semibold rounded-full">
                            {{ $discussion->media_type == 'anime' ? '🎌 Anime' : '🎬 Movie' }}
                        </span>
                        <span
                            class="px-2.5 sm:px-3 py-1 bg-slate-700/50 text-gray-300 border border-gray-600 text-xs font-semibold rounded-full">
                            #{{ ucfirst($discussion->category) }}
                        </span>
                        <span class="text-gray-500 text-xs sm:text-sm ml-auto flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($discussion->views) }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1
                        class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-3 sm:mb-4 leading-tight">
                        {{ $discussion->title }}
                    </h1>

                    {{-- Author & Date --}}
                    <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6 pb-4 sm:pb-6 border-b border-gray-700">
                        <div
                            class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-red-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            {{ strtoupper(substr($discussion->user->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-white font-semibold text-sm sm:text-base truncate">
                                {{ $discussion->user->name }}</div>
                            <div class="text-gray-400 text-xs sm:text-sm">{{ $discussion->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    {{-- Media Poster --}}
                    @if ($discussion->media_poster)
                        <div class="mb-4 sm:mb-6">
                            <div class="relative bg-slate-900/50 rounded-lg overflow-hidden">
                                <img src="{{ $discussion->media_poster }}" alt="{{ $discussion->media_title }}"
                                    class="poster-image w-full mx-auto">
                            </div>
                            <p class="text-center text-gray-400 text-xs sm:text-sm mt-2 sm:mt-3 font-medium">
                                📺 {{ $discussion->media_title }}
                            </p>
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="mb-4 sm:mb-6">
                        <p class="text-gray-300 text-sm sm:text-base leading-relaxed whitespace-pre-wrap">
                            {{ $discussion->content }}</p>
                    </div>

                    {{-- Like/Dislike & Stats --}}
                    <div class="flex items-center gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-gray-700 flex-wrap">
                        @auth
                            <form action="{{ route('fordis.like', $discussion->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="is_like" value="1">
                                <button type="submit"
                                    class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 {{ $discussion->isLikedBy(auth()->id()) ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-slate-700/50 text-gray-300 hover:bg-red-600/20 hover:text-red-400' }} rounded-lg transition-all duration-300 active:scale-95">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5"
                                        fill="{{ $discussion->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="font-semibold text-sm sm:text-base">{{ $discussion->likesCount() }}</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 bg-slate-700/50 text-gray-300 hover:bg-red-600/20 hover:text-red-400 rounded-lg transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="font-semibold text-sm sm:text-base">{{ $discussion->likesCount() }}</span>
                            </a>
                        @endauth

                        <div class="flex items-center gap-1.5 text-gray-400 text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                <path
                                    d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                            </svg>
                            <span class="font-semibold">{{ $discussion->commentsCount() }}</span>
                            <span class="hidden sm:inline">komentar</span>
                        </div>
                    </div>

                </div>

                {{-- Comments Section --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h2
                        class="text-lg sm:text-xl md:text-2xl font-bold text-white mb-4 sm:mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                            <path
                                d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        <span>Komentar</span>
                        <span class="text-gray-400 text-base sm:text-lg">({{ $discussion->commentsCount() }})</span>
                    </h2>

                    {{-- Comment Form --}}
                    @auth
                        <form action="{{ route('fordis.comment.store', $discussion->id) }}" method="POST"
                            class="mb-6 sm:mb-8">
                            @csrf
                            <div class="flex gap-2 sm:gap-3">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-red-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-lg">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <textarea name="content" rows="3" required
                                        class="w-full bg-slate-700/50 border border-gray-600 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-white text-sm sm:text-base placeholder-gray-400 focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/50 transition-all resize-none"
                                        placeholder="Tulis komentar kamu..."></textarea>
                                    <button type="submit"
                                        class="mt-2 sm:mt-3 w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base font-semibold rounded-lg transition-all duration-300 active:scale-95 shadow-lg shadow-red-600/30">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-slate-700/30 border border-gray-600 rounded-lg text-center">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-gray-600 mb-3" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-gray-400 mb-3 sm:mb-4 text-sm sm:text-base">Login untuk bergabung dalam diskusi
                            </p>
                            <a href="{{ route('login') }}"
                                class="inline-block px-5 sm:px-6 py-2 sm:py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm sm:text-base font-semibold rounded-lg transition-all duration-300 active:scale-95 shadow-lg shadow-red-600/30">
                                Login Sekarang
                            </a>
                        </div>
                    @endauth

                    {{-- Comments List --}}
                    <div class="space-y-4 sm:space-y-6">
                        @forelse($discussion->comments as $comment)
                            @include('fordis.partials.comment', [
                                'comment' => $comment,
                                'discussionId' => $discussion->id,
                            ])
                        @empty
                            <div class="text-center py-8 sm:py-12">
                                <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-600 mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-gray-400 text-sm sm:text-base mb-2">Belum ada komentar</p>
                                <p class="text-gray-500 text-xs sm:text-sm">Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-4 sm:space-y-6">

                {{-- Media Info --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                        </svg>
                        Tentang Media
                    </h3>
                    <div class="space-y-2 sm:space-y-3 text-xs sm:text-sm">
                        <div class="flex justify-between items-start gap-2">
                            <span class="text-gray-400 flex-shrink-0">Judul:</span>
                            <span class="text-white font-semibold text-right">{{ $discussion->media_title }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Tipe:</span>
                            <span
                                class="text-white font-medium">{{ $discussion->media_type == 'anime' ? 'Anime' : 'Movie' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Kategori:</span>
                            <span class="text-white font-medium">#{{ ucfirst($discussion->category) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Forum Rules --}}
                <div
                    class="bg-gradient-to-br from-red-600/20 to-purple-600/20 border border-red-500/30 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                    <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4 flex items-center gap-2">
                        <span class="text-lg sm:text-xl">📜</span>
                        Aturan Forum
                    </h3>
                    <ul class="space-y-2 sm:space-y-2.5 text-gray-300 text-xs sm:text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-0.5 flex-shrink-0">•</span>
                            <span>Hormati pendapat orang lain</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-0.5 flex-shrink-0">•</span>
                            <span>No spoiler tanpa warning</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-0.5 flex-shrink-0">•</span>
                            <span>Gunakan bahasa yang sopan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-400 mt-0.5 flex-shrink-0">•</span>
                            <span>Dilarang spam dan iklan</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

    {{-- JavaScript untuk Toggle Reply Form --}}
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                form.querySelector('textarea').focus();
            } else {
                form.classList.add('hidden');
            }
        }
    </script>

</body>

</html>
