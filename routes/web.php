<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Album;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $albums = Album::latest()->limit(3)->get();
    return view('home', compact('albums'));
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/perfil',        [UserController::class, 'show'])->name('user.profile');
    Route::get('/perfil/editar', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/perfil',        [UserController::class, 'update'])->name('user.update');
});


Route::get('/perfil/{user}', [UserController::class, 'show'])
    ->name('user.profile.public');


Route::middleware('auth')->group(function () {
    Route::resource('reviews',  ReviewController::class);
    Route::resource('comments', CommentController::class);
});

//CRUD Privado de Álbumes y Artistas — solo Admin/Editor
Route::middleware(['auth','can:manage-content'])->group(function () {
    Route::get('artists/crud', [ArtistController::class, 'index'])
        ->name('artists.crud');
    Route::get('albums/crud',  [AlbumController::class, 'index'])
        ->name('albums.crud');

    // Rutas de creación, edición, borrado
    Route::resource('artists', ArtistController::class)
        ->except(['index','show']);
    Route::resource('albums',  AlbumController::class)
        ->except(['index','show']);
});


Route::resource('albums',  AlbumController::class)->only(['index','show']);
Route::resource('artists', ArtistController::class)->only(['index','show']);
Route::get('/news',   [NewsController::class,   'index'])->name('news.index');
Route::get('/review',[ReviewController::class, 'index'])->name('review.index');

Route::resource('reviews', ReviewController::class)->only(['index', 'detail']);
Route::resource('reviews', ReviewController::class);

Route::middleware('auth')->group(function () {
    Route::resource('reviews', ReviewController::class)->except(['crud', 'show']);
    Route::post('/reviews/{review}/comments', [ReviewController::class, 'storeComment'])->name('reviews.comments.store');
});


require __DIR__.'/auth.php';
