<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        $carouselNews = News::latest()->take(5)->get();
        $latestNews = News::latest()->take(3)->get();
        $categoriesWithNews = Category::with(['latestNews'])->get();

        return view('news.index', compact('carouselNews', 'latestNews', 'categoriesWithNews', 'news'));
    }


    public function show(News $news)
    {
        $comments = $news->comments()->latest()->get();
        return view('news.show', compact('news', 'comments'));
    }

    public function crud(Request $request)
    {
        $query = News::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::select('category')->distinct()->get();

        return view('news.crud', compact('news', 'categories'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $news = new News($validated);
        $news->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $news->image = $request->file('image')->store('news_images', 'public');
        }

        $news->save();

        return redirect()->route('news.crud')->with('mensaje', 'Noticia creada con éxito');
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $news->fill($validated);

        if ($request->hasFile('image')) {
            $news->image = $request->file('image')->store('news_images', 'public');
        }

        $news->save();

        return redirect()->route('news.crud')->with('mensaje', 'Noticia actualizada con éxito');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.crud')->with('mensaje', 'Noticia eliminada con éxito');
    }
}

