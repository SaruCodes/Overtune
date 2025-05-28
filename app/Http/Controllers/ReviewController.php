<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ReviewController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $featuredReviews = Review::with('album', 'user')
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        $recentReviews = Review::with('user', 'album')
            ->orderByDesc('created_at')
            ->paginate(6);

        $topAlbums = Album::withCount('review')
            ->orderByDesc('review_count')
            ->limit(5)
            ->get();


        return view('review.index', compact('recentReviews', 'topAlbums', 'featuredReviews'));
    }

    public function create(Request $request)
    {
        $album = null;
        if ($request->filled('album_id')) {
            $album = Album::findOrFail($request->album_id);
        }
        return view('review.create', compact('album'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'rating' => 'required|numeric|min:0.5|multiple_of:0.5',
            'content' => 'required|string|min:50|max:3000',
        ]);

        $validated['user_id'] = auth()->id();

        Review::create($validated);

        return redirect()->route('review.index')->with('success', 'Reseña creada correctamente.');
    }

    public function show($id)
    {
        $review = Review::with(['comments.user', 'album.artist'])->findOrFail($id);
        $comments = $review->comments()->with('user')->get();

        return view('review.show', compact('review', 'comments'));
    }

    public function edit(Review $review)
    {
        Gate::authorize('update', $review);
        $albums = Album::all();
        return view('review.edit', compact('review', 'albums'));
    }

    public function update(Request $request, Review $review)
    {
        Gate::authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|numeric|min:0.5|max:5|multiple_of:0.5',
            'content' => 'required|string|min:100|max:3000'
        ]);

        $review->update($validated);

        return redirect()->route('review.show', $review)
            ->with('success', 'Reseña actualizada!');
    }

    public function destroy(Review $review)
    {
        $user = auth()->user();
        if ($review->user_id !== $user->id && !$user->hasRole('admin') && !$user->hasRole('editor')) {
            abort(403, 'No tienes permiso para eliminar este comentario.');
        }
        $review->delete();
        return redirect()->route('review.index')
            ->with('success', 'Reseña eliminada!');
    }

    public function crud()
    {
        $user = auth()->user();

        $reviews = Review::with('album.artist')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('review.crud', compact('reviews'));
    }

    public function storeComment(Request $request, Review $review)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:10|max:500'
        ]);

        $review->comentarios()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        return back()->with('success', 'Comentario agregado!');
    }

    //Método para las reseñas destacadas
    public function feature(Request $request, Review $review)
    {
        $this->authorize('update', $review);
        $type = $request->input('type');
        $review->is_featured_primary = $type === 'primary';
        $review->is_featured_secondary = $type === 'secondary';

        if (!in_array($type, ['primary', 'secondary'])) {
            $review->is_featured_primary = false;
            $review->is_featured_secondary = false;
        }

        $review->save();
        return redirect()->back()->with('success', 'Tipo de reseña actualizado.');
    }

}
