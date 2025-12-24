<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class EntertainmentController extends Controller
{
    public function index()
    {
        // 1. Siapkan variabel default (Kosong)
        // Ini penting agar jika API gagal, variabel ini tetap ada isinya (array kosong)
        $animeData = [];
        $movieData = [];

        // 2. Ambil Data Anime (Dengan Pengaman)
        try {
            // Kita pakai timeout 5 detik agar loading tidak selamanya jika Jikan lemot
            $jikan = Http::timeout(5)->get('https://api.jikan.moe/v4/top/anime');

            if ($jikan->successful()) {
                $animeData = $jikan->json()['data'] ?? [];
            }
        } catch (\Exception $e) {
            // Jika error, biarkan $animeData tetap kosong, jangan matikan web
            // Opsional: Log errornya -> \Log::error($e->getMessage());
        }

        // 3. Ambil Data TMDB (Dengan Pengaman)
        try {
            $apiKey = env('TMDB_API_KEY');

            // Cek API Key dulu
            if ($apiKey) {
                $tmdb = Http::timeout(5)->get('https://api.themoviedb.org/3/movie/popular', [
                    'api_key' => $apiKey
                ]);

                if ($tmdb->successful()) {
                    $movieData = $tmdb->json()['results'] ?? [];
                }
            }
        } catch (\Exception $e) {
            // Jika error, biarkan $movieData tetap kosong
        }

        // 4. Kirim ke View
        // Pastikan nama view sesuai dengan lokasi file Anda!
        return view('homes.home', [
            'animes' => $animeData,
            'movies' => $movieData
        ]);
    }
}
