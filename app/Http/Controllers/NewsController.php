<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $carouselNews = News::latest()->take(5)->get();
        $latestNews = News::latest()->take(3)->get();
        $categoriesWithNews = Category::with('latestNews')->get();

        return view('news.index', compact('carouselNews', 'latestNews', 'categoriesWithNews'));
    }


    public function show(News $news)
    {
        $comments = $news->comments()->latest()->get();
        return view('news.show', compact('news', 'comments'));
    }

    public function crud()
    {
        $news = News::with('category')->latest()->paginate(10);
        return view('news.crud', compact('news'));
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
