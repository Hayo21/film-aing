<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntertainmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FordisController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN PUBLIK ---

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Film + Anime
Route::get('/hiburan', [EntertainmentController::class, 'index']);

// Category Film and Anime
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{name}', [CategoryController::class, 'show'])->name('categories.show');

// Fordis (Forum Diskusi) - Public Read
Route::get('/fordis', [FordisController::class, 'index'])->name('fordis');
Route::get('/fordis/{id}', [FordisController::class, 'show'])->name('fordis.show');

// Halaman Statis
Route::get('/about', fn() => view('about.about'))->name('about');

// Route Info Selengkapnya (Card)
Route::get('/movie/{id}', [HomeController::class, 'showMovie'])->name('movie.detail');
Route::get('/anime/{id}', [HomeController::class, 'showAnime'])->name('anime.detail');
Route::get('/detail-movie/{id}', [HomeController::class, 'showMovie'])->name('homes.detail-movie');
Route::get('/detail-anime/{id}', [HomeController::class, 'showAnime'])->name('homes.detail-anime');


// --- GUEST ROUTES (Login, Register, OAuth) ---
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    // Register routes  
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:5,60')
        ->name('register.store');

    // Google OAuth
    Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])
        ->middleware('throttle:10,1')
        ->name('google.login');

    Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])
        ->middleware('throttle:10,1');
});


// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {
    // Fordis Actions
    Route::get('/fordis-create', [FordisController::class, 'create'])->name('fordis.create');
    Route::post('/fordis', [FordisController::class, 'store'])->name('fordis.store');
    Route::post('/fordis/{id}/like', [FordisController::class, 'toggleLike'])->name('fordis.like');

    // Comment Routes - DIPERBAIKI DISINI
    Route::post('/fordis/{id}/comment', [FordisController::class, 'storeComment'])->name('fordis.comment.store');
    Route::post('/comment/{comment}/like', [FordisController::class, 'toggleCommentLike'])->name('fordis.comment.like');

    // Comments (Movie & Anime)
    Route::post('/comments', [HomeController::class, 'storeComment'])->name('comments.store');
    Route::delete('/comments/{id}', [HomeController::class, 'deleteComment'])->name('comments.delete');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bookmarks
    Route::get('/bookmark', [BookmarkController::class, 'index'])->name('bookmark.index');
    Route::post('/bookmark/toggle', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::delete('/bookmark/{id}', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');
});

// Dashboard redirect ke fordis
Route::get('/dashboard', function () {
    return redirect()->route('fordis');
})->middleware(['auth', 'verified'])->name('dashboard');

// Require Default Auth Routes
require __DIR__ . '/auth.php';
