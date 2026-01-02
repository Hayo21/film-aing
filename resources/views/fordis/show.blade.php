<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $discussion->title }} | FORDIS</title>
    <style>
        body {
            background-color: #0F172A;
            margin-top: 8vh;
        }
    </style>
</head>

<body>
    <x-navbar />

    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-16 py-6 sm:py-8 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-2">

                {{-- Discussion Header --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-6 mb-6">
                    <div class="flex items-start gap-4 mb-4">
                        @if ($discussion->media_poster)
                            <img src="{{ $discussion->media_poster }}" alt="Poster"
                                class="w-32 h-48 object-cover rounded-lg shadow-lg">
                        @endif

                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="px-3 py-1 {{ $discussion->media_type == 'anime' ? 'bg-blue-600/30 text-blue-300' : 'bg-purple-600/30 text-purple-300' }} text-xs font-semibold rounded-full">
                                    {{ $discussion->media_type == 'anime' ? 'Anime' : 'Movie' }}
                                </span>
                                <span class="text-gray-400 text-sm">{{ $discussion->media_title }}</span>
                            </div>

                            <h1 class="text-2xl md:text-3xl font-bold text-white mb-4">
                                {{ $discussion->title }}
                            </h1>

                            <div class="flex items-center gap-4 text-sm text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-red-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($discussion->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold">{{ $discussion->user->name }}</p>
                                        <p class="text-xs">{{ $discussion->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span>•</span>
                                <span>{{ $discussion->views }} views</span>
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-invert max-w-none">
                        <p class="text-gray-300 leading-relaxed">{{ $discussion->content }}</p>
                    </div>

                    {{-- Like/Dislike Buttons --}}
                    <div class="flex items-center gap-4 mt-6 pt-6 border-t border-gray-700">
                        @auth
                            <form action="{{ route('fordis.like', $discussion->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="is_like" value="1">
                                <button type="submit"
                                    class="flex items-center gap-2 px-4 py-2 {{ $discussion->isLikedBy(auth()->id()) ? 'bg-red-600 text-white' : 'bg-slate-700 text-gray-300 hover:bg-slate-600' }} rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="font-semibold">{{ $discussion->likesCount() }} Suka</span>
                                </button>
                            </form>

                            <form action="{{ route('fordis.like', $discussion->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="is_like" value="0">
                                <button type="submit"
                                    class="flex items-center gap-2 px-4 py-2 {{ $discussion->isDislikedBy(auth()->id()) ? 'bg-gray-600 text-white' : 'bg-slate-700 text-gray-300 hover:bg-slate-600' }} rounded-lg transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                                    </svg>
                                    <span class="font-semibold">{{ $discussion->dislikesCount() }}</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-slate-700 text-gray-300 rounded-lg">
                                Login untuk memberikan reaksi
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- Comments Section --}}
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-white mb-6">
                        Komentar ({{ $discussion->commentsCount() }})
                    </h2>

                    {{-- Comment Form --}}
                    @auth
                        <form action="{{ route('fordis.comment', $discussion->id) }}" method="POST" class="mb-6">
                            @csrf
                            <textarea name="content" rows="3"
                                class="w-full bg-slate-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:border-red-500 resize-none"
                                placeholder="Tulis komentar..." required></textarea>
                            <button type="submit"
                                class="mt-3 px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                Kirim Komentar
                            </button>
                        </form>
                    @else
                        <div class="mb-6 p-4 bg-slate-700/50 border border-gray-600 rounded-lg text-center">
                            <p class="text-gray-300 mb-3">Silahkan login untuk berkomentar</p>
                            <a href="{{ route('login') }}"
                                class="inline-block px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                Login
                            </a>
                        </div>
                    @endauth

                    {{-- Comments List --}}
                    <div class="space-y-4">
                        @forelse($discussion->comments as $comment)
                            <div class="flex gap-3 p-4 bg-slate-700/30 rounded-lg">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                    {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-white font-semibold">{{ $comment->user->name }}</span>
                                        <span
                                            class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-300 text-sm">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-400 py-8">Belum ada komentar. Jadilah yang pertama!</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6">
                <div class="bg-slate-800/50 border border-gray-700 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4">Tentang Media</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Tipe:</span>
                            <span class="text-white font-semibold">{{ ucfirst($discussion->media_type) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Judul:</span>
                            <span class="text-white font-semibold">{{ $discussion->media_title }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Kategori:</span>
                            <span class="text-white font-semibold">{{ $discussion->category }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>
