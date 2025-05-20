<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/perfil',        [UserController::class, 'show'])->name('user.profile');
    Route::get('/perfil/editar', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/perfil',        [UserController::class, 'update'])->name('user.update');
});

Route::get('/perfil/{user}', [UserController::class, 'show'])->name('user.profile.public');

Route::middleware('auth')->group(function () {
    Route::resource('review', ReviewController::class);
    Route::post('/review/{review}/comments', [ReviewController::class, 'storeComment'])->name('review.comments.store');
});

Route::middleware('auth')->group(function () {
    Route::resource('comments', CommentController::class);
});

Route::middleware(['auth','can:manage-content'])->group(function () {
    Route::get('artists/crud', [ArtistController::class, 'index'])->name('artists.crud');
    Route::get('albums/crud',  [AlbumController::class, 'index'])->name('albums.crud');

    Route::resource('artists', ArtistController::class)->except(['index','show']);
    Route::resource('albums',  AlbumController::class)->except(['index','show']);
});

Route::get('/albums/search', [AlbumController::class, 'search'])->name('albums.search');
Route::resource('albums',  AlbumController::class)->only(['index','show']);
Route::resource('artists', ArtistController::class)->only(['index','show']);
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::resource('review', ReviewController::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/reviews/crud', [ReviewController::class, 'crud'])->name('review.crud');
});


require __DIR__.'/auth.php';
