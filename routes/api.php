<?php
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\AlbumController;

Route::apiResource('artists', ArtistController::class);
Route::apiResource('albums', AlbumController::class);


