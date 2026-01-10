{{-- resources/views/fordis/partials/comment.blade.php --}}

<div class="comment-item">
    {{-- Comment Container --}}
    <div class="flex gap-2 sm:gap-3 md:gap-4">

        {{-- Avatar --}}
        <div class="flex-shrink-0">
            <div
                class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-lg">
                {{ strtoupper(substr($comment->user->name, 0, 2)) }}
            </div>
        </div>

        {{-- Comment Content --}}
        <div class="flex-1 min-w-0">

            {{-- Header --}}
            <div class="flex items-center gap-1.5 sm:gap-2 mb-1.5 sm:mb-2 flex-wrap">
                <span
                    class="text-white font-semibold text-xs sm:text-sm md:text-base truncate max-w-[150px] sm:max-w-none">
                    {{ $comment->user->name }}
                </span>
                <span class="text-gray-500 text-xs flex-shrink-0">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
                @if ($comment->parent_id)
                    <span
                        class="px-1.5 sm:px-2 py-0.5 bg-blue-600/30 text-blue-300 border border-blue-500/30 text-xs rounded-full flex-shrink-0">
                        Reply
                    </span>
                @endif
            </div>

            {{-- Comment Text --}}
            <div class="bg-slate-700/30 rounded-lg px-3 py-2 sm:px-3.5 sm:py-2.5 mb-2 sm:mb-3 border border-gray-700/50">
                <p class="text-gray-300 text-xs sm:text-sm md:text-base leading-relaxed break-words">
                    {{ $comment->content }}
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 sm:gap-3 md:gap-4 text-xs flex-wrap">

                {{-- Like Button --}}
                @auth
                    <form action="{{ route('fordis.comment.like', $comment->id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="is_like" value="1">
                        <button type="submit"
                            class="flex items-center gap-1 px-2 sm:px-2.5 py-1 sm:py-1.5 rounded-md {{ $comment->isLikedBy(auth()->id()) ? 'bg-green-600/20 text-green-400 border border-green-500/30' : 'bg-slate-700/30 text-gray-400 hover:text-green-400 hover:bg-green-600/10 border border-transparent hover:border-green-500/30' }} transition-all duration-300 active:scale-95">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4"
                                fill="{{ $comment->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="font-semibold text-xs sm:text-sm">{{ $comment->likesCount() }}</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-1 px-2 sm:px-2.5 py-1 sm:py-1.5 rounded-md bg-slate-700/30 text-gray-400 hover:text-green-400 hover:bg-green-600/10 border border-transparent hover:border-green-500/30 transition-all duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <span class="font-semibold text-xs sm:text-sm">{{ $comment->likesCount() }}</span>
                    </a>
                @endauth

                {{-- Dislike Button --}}
                @auth
                    <form action="{{ route('fordis.comment.like', $comment->id) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="is_like" value="0">
                        <button type="submit"
                            class="flex items-center gap-1 px-2 sm:px-2.5 py-1 sm:py-1.5 rounded-md {{ $comment->isDislikedBy(auth()->id()) ? 'bg-red-600/20 text-red-400 border border-red-500/30' : 'bg-slate-700/30 text-gray-400 hover:text-red-400 hover:bg-red-600/10 border border-transparent hover:border-red-500/30' }} transition-all duration-300 active:scale-95">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4"
                                fill="{{ $comment->isDislikedBy(auth()->id()) ? 'currentColor' : 'none' }}"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                            </svg>
                            <span class="font-semibold text-xs sm:text-sm">{{ $comment->dislikesCount() }}</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-1 px-2 sm:px-2.5 py-1 sm:py-1.5 rounded-md bg-slate-700/30 text-gray-400 hover:text-red-400 hover:bg-red-600/10 border border-transparent hover:border-red-500/30 transition-all duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                        </svg>
                        <span class="font-semibold text-xs sm:text-sm">{{ $comment->dislikesCount() }}</span>
                    </a>
                @endauth

                {{-- Reply Button --}}
                @auth
                    <button onclick="toggleReplyForm({{ $comment->id }})"
                        class="flex items-center gap-1 px-2 sm:px-2.5 py-1 sm:py-1.5 rounded-md bg-slate-700/30 text-gray-400 hover:text-blue-400 hover:bg-blue-600/10 border border-transparent hover:border-blue-500/30 transition-all duration-300 active:scale-95">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        <span class="hidden sm:inline text-xs sm:text-sm">Balas</span>
                    </button>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-1 px-2 sm:px-2.5 py-1 sm:py-1.5 rounded-md bg-slate-700/30 text-gray-400 hover:text-blue-400 hover:bg-blue-600/10 border border-transparent hover:border-blue-500/30 transition-all duration-300">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        <span class="hidden sm:inline text-xs sm:text-sm">Balas</span>
                    </a>
                @endauth

                {{-- Reply Count --}}
                @if ($comment->replies->count() > 0)
                    <span class="text-gray-500 text-xs flex items-center gap-1">
                        <span class="hidden sm:inline">•</span>
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                        </svg>
                        <span>{{ $comment->replies->count() }}</span>
                    </span>
                @endif
            </div>

            {{-- Reply Form (Hidden by default) --}}
            @auth
                <div id="reply-form-{{ $comment->id }}" class="reply-form hidden mt-3 sm:mt-4">
                    <form action="{{ route('fordis.comment.store', $discussionId) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="bg-slate-700/20 rounded-lg p-2 sm:p-3 border border-gray-600">
                            <textarea name="content" rows="2" required
                                class="w-full bg-slate-700/50 border border-gray-600 rounded-lg px-2.5 sm:px-3 py-1.5 sm:py-2 text-white text-xs sm:text-sm placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition-all resize-none"
                                placeholder="Balas ke {{ $comment->user->name }}..."></textarea>
                            <div class="flex gap-2 mt-2">
                                <button type="submit"
                                    class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-300 active:scale-95 shadow-lg shadow-blue-600/30">
                                    Kirim
                                </button>
                                <button type="button" onclick="toggleReplyForm({{ $comment->id }})"
                                    class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 bg-slate-600 hover:bg-slate-700 text-white text-xs sm:text-sm font-semibold rounded-lg transition-all duration-300 active:scale-95">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth

            {{-- Nested Replies (Recursive) --}}
            @if ($comment->replies->count() > 0)
                <div class="reply-indent mt-3 sm:mt-4 space-y-3 sm:space-y-4">
                    @foreach ($comment->replies as $reply)
                        @include('fordis.partials.comment', [
                            'comment' => $reply,
                            'discussionId' => $discussionId,
                        ])
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
