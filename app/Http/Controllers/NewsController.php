<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index()
    {
        $latestNews = News::latest()->take(6)->get();
        $categoriesWithNews = Category::with(['news' => function($q) {
            $q->latest()->take(3);
        }])->get();

        return view('news.index', compact('latestNews', 'categoriesWithNews'));
    }

    public function show(News $news)
    {
        $comments = $news->comments()->latest()->get();
        return view('news.show', compact('news', 'comments'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'editor'])) {
            abort(403, 'No tienes permisos para crear noticias.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|min:255|max:3000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $validated['user_id'] = $user->id;
        News::create($validated);
        return redirect()->route('news.crud')->with('mensaje', 'Noticia creada correctamente.');
    }


    public function crud(Request $request)
    {
        $query = News::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $news = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('news.crud', compact('news', 'categories'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'editor'])) {
            abort(403);
        }

        $categories = Category::all();
        return view('news.create', compact('categories'));
    }


    public function update(Request $request, News $news)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['admin', 'editor'])) {
            abort(403, 'No tienes permisos para editar noticias.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|min:255|max:3000',
            'category_id' => 'required|exists:categories,id',
        ]);

        $news->update($validated);
        return redirect()->route('news.crud')->with('mensaje', 'Noticia actualizada correctamente.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.crud')->with('success', 'Noticia eliminada correctamente.');
    }


}
