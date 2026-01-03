<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FordisController;


// tes api
// Route::get('/test-api', [EntertainmentController::class, 'test']);

// halaman utama (PAKAI CONTROLLER)
Route::get('/', [HomeController::class, 'index'])->name('home');

// film + anime
Route::get('/hiburan', [EntertainmentController::class, 'index']);

// category film and anime
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/categories/{name}', [CategoryController::class, 'show'])
    ->name('categories.show');

// Fordis
Route::get('/fordis', [FordisController::class, 'index'])->name('fordis');
Route::get('/fordis/{id}', [FordisController::class, 'show'])->name('fordis.show');

Route::middleware('auth')->group(function () {
    Route::get('/fordis-create', [FordisController::class, 'create'])->name('fordis.create');
    Route::post('/fordis', [FordisController::class, 'store'])->name('fordis.store');
    Route::post('/fordis/{id}/like', [FordisController::class, 'toggleLike'])->name('fordis.like');
    Route::post('/fordis/{id}/comment', [FordisController::class, 'storeComment'])->name('fordis.comment');
});

// halaman statis
Route::get('/about', fn() => view('about.about'))->name('about');

// route info selengkapnya untuk card
Route::get('/movie/{id}', [HomeController::class, 'showMovie'])->name('movie.detail');
Route::get('/anime/{id}', [HomeController::class, 'showAnime'])->name('anime.detail');

// 
Route::get('/detail-movie/{id}', [HomeController::class, 'showMovie'])->name('homes.detail-movie');
Route::get('/detail-anime/{id}', [HomeController::class, 'showAnime'])->name('homes.detail-anime');

// Dashboard redirect ke fordis
Route::get('/dashboard', function () {
    return redirect()->route('fordis');
})->middleware(['auth', 'verified'])->name('dashboard');

// Comment routes (untuk movie & anime)
Route::middleware('auth')->group(function () {
    Route::post('/comments', [HomeController::class, 'storeComment'])->name('comments.store');
    Route::delete('/comments/{id}', [HomeController::class, 'deleteComment'])->name('comments.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
