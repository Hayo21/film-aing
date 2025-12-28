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
        // Cache selama 24 jam untuk mengurangi API calls
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

        if (empty($apiKey)) {
            return [];
        }

        $finalGenres = [];

        // Parallel requests untuk TMDB (lebih cepat)
        try {
            $responses = Http::pool(fn($pool) => [
                $pool->as('movie')->timeout(5)->get("{$baseUrlTmdb}/genre/movie/list", [
                    'api_key' => $apiKey,
                    'language' => 'en-US'
                ]),
                $pool->as('tv')->timeout(5)->get("{$baseUrlTmdb}/genre/tv/list", [
                    'api_key' => $apiKey,
                    'language' => 'en-US'
                ]),
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
            Log::error('TMDB API Error: ' . $e->getMessage());
        }

        // Fetch Jikan (Anime)
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
            Log::error('Jikan API Error: ' . $e->getMessage());
        }

        ksort($finalGenres);
        return $finalGenres;
    }

    public function show(Request $request, $name)
    {
        return view('categories.show', [
            'name' => $name,
            'tmdb_id' => $request->query('tmdb_id'),
            'jikan_id' => $request->query('jikan_id')
        ]);
    }
}
