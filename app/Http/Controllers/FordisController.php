<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FordisController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'trending');

        $query = Discussion::with(['user', 'likes', 'comments']);

        switch ($filter) {
            case 'movies':
                $query->where('media_type', 'movie');
                break;
            case 'anime':
                $query->where('media_type', 'anime');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'latest':
                $query->latest();
                break;
            default:
                $query->withCount('likes')
                    ->orderBy('likes_count', 'desc')
                    ->orderBy('created_at', 'desc');
        }

        $discussions = $query->paginate(10);

        $trendingTopics = Discussion::select('category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->take(4)
            ->get();

        return view('fordis.fordis', compact('discussions', 'trendingTopics', 'filter'));
    }

    public function show($id)
    {
        $discussion = Discussion::with([
            'user',
            'comments' => function ($query) {
                // Hanya ambil parent comments (yang tidak punya parent_id)
                $query->whereNull('parent_id')
                    ->with(['user', 'replies.user', 'replies.likes', 'likes'])
                    ->latest();
            },
            'likes'
        ])->findOrFail($id);

        $discussion->increment('views');

        return view('fordis.show', compact('discussion'));
    }

    public function create()
    {
        return view('fordis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'media_type' => 'required|in:movie,anime',
            'media_id' => 'required',
            'media_title' => 'required',
            'media_poster' => 'nullable',
            'category' => 'required'
        ]);

        $discussion = Discussion::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'media_type' => $request->media_type,
            'media_id' => $request->media_id,
            'media_title' => $request->media_title,
            'media_poster' => $request->media_poster,
            'category' => $request->category
        ]);

        return redirect()->route('fordis.show', $discussion->id)
            ->with('success', 'Diskusi berhasil dibuat!');
    }

    public function toggleLike(Request $request, $id)
    {
        $discussion = Discussion::findOrFail($id);
        $userId = Auth::id();

        $like = $discussion->likes()->where('user_id', $userId)->first();

        if ($like) {
            if ($like->is_like == $request->is_like) {
                $like->delete();
            } else {
                $like->update(['is_like' => $request->is_like]);
            }
        } else {
            $discussion->likes()->create([
                'user_id' => $userId,
                'is_like' => $request->is_like
            ]);
        }

        return back()->with('success', 'Berhasil!');
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $discussion = Discussion::findOrFail($id);

        // Gunakan polymorphic relationship
        $discussion->comments()->create([
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Toggle like/dislike untuk comment
    public function toggleCommentLike(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $userId = Auth::id();

        $like = $comment->likes()->where('user_id', $userId)->first();

        if ($like) {
            if ($like->is_like == $request->is_like) {
                $like->delete();
            } else {
                $like->update(['is_like' => $request->is_like]);
            }
        } else {
            $comment->likes()->create([
                'user_id' => $userId,
                'is_like' => $request->is_like
            ]);
        }

        return back()->with('success', 'Berhasil!');
    }
}
