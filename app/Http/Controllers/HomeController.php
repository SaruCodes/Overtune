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
        $topReviewedAlbums = Album::withCount('review')->orderByDesc('review_count')->take(5)->get();

        $categories = Category::with(['news' => function ($query) {
            $query->latest()->take(1);
        }])->get();

        $latestByCategory = collect();
        foreach ($categories as $category) {
            if ($category->news->isNotEmpty()) {
                $latestByCategory->push($category->news->first());
            }
        }

        $carouselNews = $latestByCategory->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'summary' => \Illuminate\Support\Str::limit(strip_tags($n->content), 120),
                'url' => route('news.show', $n->id),
                'image_url' => asset('storage/' . $n->image),
            ];
        });

        return view('home', compact('latestAlbums', 'featuredReview', 'secondaryReview', 'featuredNews', 'latestNews', 'latestByCategory', 'topReviewedAlbums', 'carouselNews'));
    }
}
