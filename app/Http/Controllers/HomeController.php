<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class HomeController extends Controller
{
    // Konstanta untuk cache duration (dalam detik)
    private const CACHE_DURATION = 3600; // 1 jam
    private const API_TIMEOUT = 5;

    public function index()
    {
        // Ambil data dengan caching untuk performa lebih cepat
        $animes = $this->getTopAnime();
        $movies = $this->getPopularMovies();

        // Build carousel slides dari data yang sudah diambil
        $slides = $this->buildCarouselSlides($movies, $animes);

        // Kirim semua data ke view
        return view('homes.home', [
            'animes' => $animes,
            'movies' => $movies,
            'slides' => $slides
        ]);
    }

    /**
     * Ambil data anime dari Jikan API dengan caching
     * * @return array
     */
    private function getTopAnime(): array
    {
        return Cache::remember('top_anime', self::CACHE_DURATION, function () {
            try {
                /** @var Response $response */
                $response = Http::timeout(self::API_TIMEOUT)
                    ->get('https://api.jikan.moe/v4/top/anime', [
                        'limit' => 20 // Batasi hanya 20 untuk performa
                    ]);

                if ($response->successful()) {
                    return $response->json()['data'] ?? [];
                }
            } catch (\Exception $e) {
                Log::error('Jikan API Error: ' . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Ambil data movie dari TMDB API dengan caching
     * * @return array
     */
    private function getPopularMovies(): array
    {
        $apiKey = env('TMDB_API_KEY');

        if (!$apiKey) {
            return [];
        }

        return Cache::remember('popular_movies_v2', self::CACHE_DURATION, function () use ($apiKey) {
            try {
                // Ambil versi Bahasa Indonesia
                /** @var Response $responseID */
                $responseID = Http::timeout(self::API_TIMEOUT)
                    ->get('https://api.themoviedb.org/3/movie/popular', [
                        'api_key'  => $apiKey,
                        'language' => 'id-ID',
                        'page'     => 1
                    ]);

                // Ambil versi Bahasa Inggris sebagai fallback
                /** @var Response $responseEN */
                $responseEN = Http::timeout(self::API_TIMEOUT)
                    ->get('https://api.themoviedb.org/3/movie/popular', [
                        'api_key'  => $apiKey,
                        'language' => 'en-US',
                        'page'     => 1
                    ]);

                if ($responseID->successful() && $responseEN->successful()) {
                    $moviesID = $responseID->json()['results'] ?? [];
                    $moviesEN = $responseEN->json()['results'] ?? [];

                    // Merge: gunakan overview EN jika ID kosong
                    $mergedMovies = [];
                    foreach ($moviesID as $index => $movieID) {
                        $movieEN = $moviesEN[$index] ?? [];

                        $mergedMovies[] = [
                            'id'            => $movieID['id'],
                            'title'         => $movieID['title'] ?? $movieEN['title'] ?? 'Unknown',
                            'overview'      => !empty(trim($movieID['overview'] ?? ''))
                                ? $movieID['overview']
                                : ($movieEN['overview'] ?? ''),
                            'poster_path'   => $movieID['poster_path'] ?? $movieEN['poster_path'] ?? null,
                            'backdrop_path' => $movieID['backdrop_path'] ?? $movieEN['backdrop_path'] ?? null,
                            'vote_average'  => $movieID['vote_average'] ?? $movieEN['vote_average'] ?? 0,
                            'release_date'  => $movieID['release_date'] ?? $movieEN['release_date'] ?? '',
                            'genre_ids'     => $movieID['genre_ids'] ?? $movieEN['genre_ids'] ?? [],
                        ];
                    }

                    return $mergedMovies;
                }

                // Fallback: gunakan EN saja jika ID gagal
                if ($responseEN->successful()) {
                    return $responseEN->json()['results'] ?? [];
                }
            } catch (\Exception $e) {
                Log::error('TMDB API Error: ' . $e->getMessage());
            }

            return [];
        });
    }

    /**
     * Build data carousel slides (2 movies + 2 anime)
     * * @return array
     */
    private function buildCarouselSlides(array $movies, array $animes): array
    {
        $slides = [];

        // Ambil 2 film terpopuler
        foreach (array_slice($movies, 0, 2) as $index => $movie) {
            $slides[] = [
                'img'    => $this->getTmdbImageUrl($movie['backdrop_path'] ?? $movie['poster_path'] ?? null),
                'badge'  => $index === 0 ? 'TOP MOVIE' : 'TRENDING MOVIE',
                'color'  => $index === 0 ? 'bg-red-600' : 'bg-yellow-500 text-black',
                'title'  => $movie['title'] ?? 'Unknown Title',
                'desc'   => $this->limitWords($movie['overview'] ?? 'Tidak ada deskripsi.', 25),
                'rating' => round($movie['vote_average'] ?? 0, 1),
            ];
        }

        // Ambil 2 anime terpopuler
        foreach (array_slice($animes, 0, 2) as $index => $anime) {
            $slides[] = [
                'img'    => $anime['images']['jpg']['large_image_url'] ?? $anime['images']['jpg']['image_url'] ?? '',
                'badge'  => $index === 0 ? 'TOP ANIME' : 'POPULAR ANIME',
                'color'  => $index === 0 ? 'bg-purple-600' : 'bg-pink-600',
                'title'  => $anime['title'] ?? 'Unknown Title',
                'desc'   => $this->limitWords($anime['synopsis'] ?? 'Tidak ada deskripsi.', 25),
                'rating' => round($anime['score'] ?? 0, 1),
            ];
        }

        // Fallback jika tidak ada data
        if (empty($slides)) {
            $slides = $this->getFallbackSlides();
        }

        return $slides;
    }

    /**
     * Batasi jumlah kata dalam teks
     */
    private function limitWords(string $text, int $limit = 25): string
    {
        $words = explode(' ', $text);

        if (count($words) > $limit) {
            return implode(' ', array_slice($words, 0, $limit)) . '...';
        }

        return $text;
    }

    /**
     * Get full TMDB image URL
     */
    private function getTmdbImageUrl(?string $path): string
    {
        if (!$path) {
            return 'https://via.placeholder.com/1920x1080?text=No+Image';
        }

        return 'https://image.tmdb.org/t/p/original' . $path;
    }

    /**
     * Fallback slides jika API gagal
     */
    private function getFallbackSlides(): array
    {
        return [
            [
                'img'    => 'https://images.unsplash.com/photo-1616530940355-351fabd9524b?w=1920',
                'badge'  => 'NEW RELEASE',
                'color'  => 'bg-red-600',
                'title'  => 'The Dark Knight',
                'desc'   => 'Ketika ancaman yang dikenal sebagai Joker muncul dari masa lalunya, Batman harus menghadapi ujian terbesar untuk memerangi ketidakadilan.',
                'rating' => 9.0,
            ],
        ];
    }

    /**
     * Mapping TMDB Genre IDs ke nama genre
     */
    public static function getGenreMap(): array
    {
        return [
            28    => 'Action',
            12    => 'Adventure',
            16    => 'Animation',
            35    => 'Comedy',
            80    => 'Crime',
            99    => 'Documentary',
            18    => 'Drama',
            10751 => 'Family',
            14    => 'Fantasy',
            36    => 'History',
            27    => 'Horror',
            10402 => 'Music',
            9648  => 'Mystery',
            10749 => 'Romance',
            878   => 'Sci-Fi',
            10770 => 'TV Movie',
            53    => 'Thriller',
            10752 => 'War',
            37    => 'Western'
        ];
    }
}
