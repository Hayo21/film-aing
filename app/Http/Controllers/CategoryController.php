<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        // Cache selama 24 jam
        $genres = Cache::remember('all_genres', 86400, function () {
            return $this->fetchGenres();
        });

        return view('categories.categories', [
            'genres' => $genres
        ]);
    }

    private function fetchGenres()
    {
        $apiKey = config('services.tmdb.api_key') ?? env('TMDB_API_KEY');
        $baseUrlTmdb = 'https://api.themoviedb.org/3';
        $baseUrlJikan = 'https://api.jikan.moe/v4';

        if (empty($apiKey)) return [];

        $finalGenres = [];

        // 1. Fetch TMDB (Parallel)
        try {
            $responses = Http::pool(fn($pool) => [
                $pool->as('movie')->timeout(5)->get("{$baseUrlTmdb}/genre/movie/list", ['api_key' => $apiKey, 'language' => 'en-US']),
                $pool->as('tv')->timeout(5)->get("{$baseUrlTmdb}/genre/tv/list", ['api_key' => $apiKey, 'language' => 'en-US']),
            ]);

            $tmdbMovie = $responses['movie']->successful() ? $responses['movie']->json()['genres'] : [];
            $tmdbTv = $responses['tv']->successful() ? $responses['tv']->json()['genres'] : [];

            $tmdbGenres = collect($tmdbMovie)->merge($tmdbTv)->unique('id');

            foreach ($tmdbGenres as $genre) {
                $name = $genre['name'];
                $finalGenres[$name] = [
                    'name' => $name,
                    'tmdb_id' => $genre['id'],
                    'jikan_id' => null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('TMDB Genre Error: ' . $e->getMessage());
        }

        // 2. Fetch Jikan
        try {
            $resJikan = Http::timeout(5)->get("{$baseUrlJikan}/genres/anime");
            /** @var Response $resJikan */
            if ($resJikan->successful()) {
                $jikanGenres = $resJikan->json()['data'] ?? [];
                foreach ($jikanGenres as $genre) {
                    $name = $genre['name'];
                    if (isset($finalGenres[$name])) {
                        $finalGenres[$name]['jikan_id'] = $genre['mal_id'];
                    } else {
                        $finalGenres[$name] = [
                            'name' => $name,
                            'tmdb_id' => null,
                            'jikan_id' => $genre['mal_id'],
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Jikan Genre Error: ' . $e->getMessage());
        }

        ksort($finalGenres);
        return $finalGenres;
    }

    public function show(Request $request, $name)
    {
        $tmdbId  = $request->query('tmdb_id');
        $jikanId = $request->query('jikan_id');
        $apiKey  = config('services.tmdb.api_key') ?? env('TMDB_API_KEY');

        $movies = [];
        $tvShows = [];
        $animes = [];

        // ================= TMDB (Movie & TV with Fallback) =================
        if ($tmdbId) {
            try {
                // Kita gunakan POOL untuk mengambil data INDO dan INGGRIS secara bersamaan
                // Ini mencegah loading lama (paralel processing)
                $responses = Http::pool(fn($pool) => [
                    // Request Movie (Indo & English)
                    $pool->as('movie_id')->get('https://api.themoviedb.org/3/discover/movie', [
                        'api_key' => $apiKey,
                        'with_genres' => $tmdbId,
                        'language' => 'id-ID'
                    ]),
                    $pool->as('movie_en')->get('https://api.themoviedb.org/3/discover/movie', [
                        'api_key' => $apiKey,
                        'with_genres' => $tmdbId,
                        'language' => 'en-US'
                    ]),

                    // Request TV (Indo & English)
                    $pool->as('tv_id')->get('https://api.themoviedb.org/3/discover/tv', [
                        'api_key' => $apiKey,
                        'with_genres' => $tmdbId,
                        'language' => 'id-ID'
                    ]),
                    $pool->as('tv_en')->get('https://api.themoviedb.org/3/discover/tv', [
                        'api_key' => $apiKey,
                        'with_genres' => $tmdbId,
                        'language' => 'en-US'
                    ]),
                ]);

                // Proses Data Movie
                if ($responses['movie_id']->successful() && $responses['movie_en']->successful()) {
                    $movies = $this->mergeLanguage(
                        $responses['movie_id']->json()['results'],
                        $responses['movie_en']->json()['results']
                    );

                    // Tandai type
                    foreach ($movies as &$m) $m['media_type'] = 'movie';
                }

                // Proses Data TV
                if ($responses['tv_id']->successful() && $responses['tv_en']->successful()) {
                    $tvShows = $this->mergeLanguage(
                        $responses['tv_id']->json()['results'],
                        $responses['tv_en']->json()['results']
                    );

                    // Tandai type
                    foreach ($tvShows as &$t) $t['media_type'] = 'tv';
                }
            } catch (\Exception $e) {
                Log::error('TMDB Discover Error: ' . $e->getMessage());
            }
        }

        // ================= JIKAN (Anime) =================
        // Jikan API defaultnya Inggris, tidak support 'id-ID' secara native
        if ($jikanId) {
            try {
                $animeRes = Http::timeout(5)->get('https://api.jikan.moe/v4/anime', [
                    'genres' => $jikanId,
                    'order_by' => 'popularity' // Tambahkan sort biar rapi
                ]);

                /** @var Response $animeRes */
                if ($animeRes->successful()) {
                    $animes = $animeRes->json()['data'] ?? [];
                    // Tandai type
                    foreach ($animes as &$a) $a['media_type'] = 'anime';
                }
            } catch (\Exception $e) {
                Log::error('Jikan Discover Error: ' . $e->getMessage());
            }
        }

        // Gabungkan semua konten
        $mixedContent = collect($movies)
            ->merge($tvShows)
            ->merge($animes)
            ->sortByDesc(fn($item) => $item['popularity'] ?? 0) // Sort popularity gabungan
            ->values(); // Reset array keys

        return view('categories.show', [
            'genreName' => $name,
            'content' => $mixedContent
        ]);
    }

    /**
     * Fungsi Helper untuk menggabungkan data Indo dan Inggris
     * Jika Overview Indo kosong, pakai Overview Inggris
     */
    private function mergeLanguage($indoList, $englishList)
    {
        // Ubah list Inggris jadi Key-Value pair berdasarkan ID biar gampang dicari
        // [123 => DataFilmInggris, 456 => DataFilmInggris]
        $englishMap = collect($englishList)->keyBy('id');

        foreach ($indoList as &$item) {
            // Cek apakah overview kosong atau null
            if (empty($item['overview'])) {
                // Ambil overview dari data Inggris jika ada
                if (isset($englishMap[$item['id']])) {
                    $item['overview'] = $englishMap[$item['id']]['overview'];
                } else {
                    $item['overview'] = 'Tidak ada deskripsi.';
                }
            }
        }

        return $indoList;
    }
}
