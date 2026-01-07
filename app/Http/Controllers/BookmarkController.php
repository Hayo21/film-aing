<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookmarkController extends Controller
{
    // Tampilkan halaman bookmark user
    public function index()
    {
        $bookmarks = Auth::user()->bookmarks()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookmark.bookmark', compact('bookmarks'));
    }

    // Toggle bookmark (tambah/hapus)
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'media_type' => 'required|in:movie,anime',
            'media_id' => 'required|string',
            'title' => 'required|string',
            'poster_url' => 'nullable|string',
            'overview' => 'nullable|string',
            'release_date' => 'nullable|string',
            'rating' => 'nullable|numeric',
        ]);

        $bookmark = Bookmark::where([
            'user_id' => Auth::id(),
            'media_type' => $validated['media_type'],
            'media_id' => $validated['media_id'],
        ])->first();

        if ($bookmark) {
            // Hapus bookmark
            $bookmark->delete();
            return back()->with('success', 'Bookmark berhasil dihapus!');
        } else {
            // Tambah bookmark
            Bookmark::create([
                'user_id' => Auth::id(),
                'media_type' => $validated['media_type'],
                'media_id' => $validated['media_id'],
                'title' => $validated['title'],
                'poster_url' => $validated['poster_url'],
                'overview' => $validated['overview'],
                'release_date' => $validated['release_date'],
                'rating' => $validated['rating'],
            ]);
            return back()->with('success', 'Bookmark berhasil ditambahkan!');
        }
    }

    // Hapus bookmark
    public function destroy($id)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())->findOrFail($id);
        $bookmark->delete();

        return back()->with('success', 'Bookmark berhasil dihapus!');
    }
}
