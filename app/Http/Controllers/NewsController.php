<?php
// app/Http/Controllers/NewsController.php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $latestNews = News::orderBy('created_at', 'desc')->take(6)->get();
        $categoriesWithNews = Category::with(['latestNews' => function ($query) {
            $query->latest()->take(3);
        }])->get();

        return view('news.index', compact('latestNews', 'categoriesWithNews'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required'
        ]);

        News::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('news.index')->with('success', 'Noticia creada.');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $this->authorize('update', $news);
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $this->authorize('update', $news);
        $request->validate([
            'titulo' => 'required|max:255',
            'contenido' => 'required'
        ]);

        $news->update($request->only(['titulo', 'contenido']));

        return redirect()->route('news.index')->with('success', 'Noticia actualizada.');
    }

    public function destroy(News $news)
    {
        $this->authorize('delete', $news);
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Noticia eliminada.');
    }
}
