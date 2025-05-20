<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Album;
use App\Models\News;

class HomeController extends Controller
{

    public function index()
    {
        $latestAlbums = Album::orderBy('created_at', 'desc')->take(3)->get();
        $featuredReview = Review::with('album')->latest()->first();
        $latestNews = News::orderBy('created_at', 'desc')->take(3)->get();

        return view('home', [
            'latestAlbums' => $latestAlbums,
            'featuredReview' => $featuredReview,
            'latestNews' => $latestNews,
        ]);
    }

}
