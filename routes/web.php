<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/contacto', function () {
    return view('contact');
})->name('contact');


//Rutas SOLO accesibles a admin y editor
Route::middleware(['auth', 'can:manage-content'])->group(function () {
    Route::get('/news/crud', [NewsController::class, 'crud'])->name('news.crud');
    Route::resource('news', NewsController::class)->except(['index', 'show']);

    Route::get('/artists/crud', [ArtistController::class, 'crud'])->name('artists.crud');
    Route::resource('artists', ArtistController::class)->except(['index', 'show']);

    Route::get('/albums/crud', [AlbumController::class, 'crud'])->name('albums.crud');
    Route::resource('albums', AlbumController::class)->except(['index', 'show']);

    Route::get('/panel', [AdminPanelController::class, 'index'])->name('admin.panel');

    Route::put('/reviews/{review}/feature', [ReviewController::class, 'feature'])->name('reviews.feature');

    Route::get('/reportes', [AdminPanelController::class, 'reports'])->name('admin.report');

    Route::put('/reportes/{id}/safe', [AdminPanelController::class, 'marcarComoSeguro'])->name('admin.report.safe');
    Route::delete('/reportes/{id}', [AdminPanelController::class, 'eliminarContenido'])->name('admin.report.delete');
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

//Rutas accesibles a ususarios autentificados
Route::middleware(['auth'])->group(function () {
    Route::get('/review/crud', [ReviewController::class, 'crud'])->name('review.crud');
    Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::get('/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
    Route::resource('comments', CommentController::class);
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/review/{review}/comments', [ReviewController::class, 'storeComment'])->name('review.comments.store');
    Route::get('/lists/create', [ListController::class, 'create'])->name('lists.create');
    Route::post('/lists', [ListController::class, 'store'])->name('lists.store');
});


//Rutas Públicas
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');
Route::get('/perfil/{user}', [UserController::class, 'show'])->name('user.profile.public');
Route::get('/albums/search', [AlbumController::class, 'search'])->name('albums.search');
Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
Route::get('/review/{review}', [ReviewController::class, 'show'])->name('review.show');
Route::get('/lists', [ListController::class, 'index'])->name('lists.index');
Route::delete('/lists/{list}', [ListController::class, 'destroy'])->name('lists.destroy');
Route::put('/lists/{list}', [ListController::class, 'update'])->name('lists.update');
Route::get('/lists/{list}', [ListController::class, 'show'])->name('lists.show');
Route::get('/lists/{list}/edit', [ListController::class, 'edit'])->name('lists.edit');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::post('/lists/{list}/favorite', [FavoriteController::class, 'toggle'])->name('lists.favorite');
Route::post('/report/{type}/{id}', [ReportController::class, 'store'])->middleware('auth');


//Rutas DE PERFIL solo para usuarios autentificados!!
Route::middleware('auth')->group(function () {
    Route::get('/perfil',        [UserController::class, 'show'])->name('user.profile');
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/perfil', [UserController::class, 'update'])->name('user.update');
});

require __DIR__.'/auth.php';
