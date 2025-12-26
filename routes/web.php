<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\HomeController;

// tes api
// Route::get('/test-api', [EntertainmentController::class, 'test']);

// halaman utama (PAKAI CONTROLLER)
Route::get('/', [HomeController::class, 'index'])->name('home');

// film + anime
Route::get('/hiburan', [EntertainmentController::class, 'index']);

// halaman statis
Route::get('/categories', fn() => view('categories.categories'))->name('categories');
Route::get('/films', fn() => view('films.films'))->name('films');
Route::get('/about', fn() => view('about.about'))->name('about');

// route info selengkapnya untuk card
Route::get('/movie/{id}', [HomeController::class, 'showMovie'])->name('movie.detail');
Route::get('/anime/{id}', [HomeController::class, 'showAnime'])->name('anime.detail');

// di bawah adalah bagian login bawaan dari laravel breeze
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';
