<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use App\Models\Album;
use App\Models\News;

class HomeController extends Controller
{

    public function index()
    {
        $latestAlbums = Album::orderBy('created_at', 'desc')->take(3)->get();
        $featuredReview = Review::with('album')->latest()->first();
        $secondaryReview = Review::latest()->skip(1)->first();
        $latestNews = News::orderBy('created_at', 'desc')->take(3)->get();
        $featuredNews = News::latest()->first();

        $categories = Category::with(['news' => function($query) {
            $query->latest()->take(1);
        }])->get();

        $latestByCategory = collect();

        foreach ($categories as $category) {
            if ($category->news->isNotEmpty()) {
                $latestByCategory->push($category->news->first());
            }
        }

        return view('home', compact(
            'latestAlbums',
            'featuredReview',
            'secondaryReview',
            'featuredNews',
            'latestNews',
            'latestByCategory'
        ));
    }

}
