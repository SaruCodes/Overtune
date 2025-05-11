<?php
use App\Http\Controllers\HomeController;
use Symfony\Component\Routing\Annotation\Route;
use App\Http\Controllers\ArtistController;

Route::apiResource('artists', ArtistController::class);

Route::get('/', [HomeController::class, 'index']);

