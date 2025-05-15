<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\UserController;
use App\Models\Album;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth','verified'])->get('/dashboard', function () {return redirect()->route('home');})->name('dashboard');

Route::get('/', function () {
    $albums = Album::latest()->limit(3)->get();
    return view('home', compact('albums'));
})->middleware(['auth','verified'])->name('home');

//Rutas de usuario y acceso al perfil
Route::get('/perfil/{user}', function (\App\Models\User $user) {
    return view('user.profile', compact('user'));
})->name('user.profile');


Route::put('/mi-perfil/{user}', [UserController::class, 'update'])->middleware('auth')->name('user.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UserController::class, 'show'])->name('user.profile');
    Route::get('/perfil/editar', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/perfil/{user}', [UserController::class, 'update'])->name('user.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('artists', ArtistController::class);
Route::resource('albums', AlbumController::class);
Route::resource('reviews', ReviewController::class)->middleware('auth');
Route::resource('comments', CommentController::class)->middleware('auth');

require __DIR__.'/auth.php';
