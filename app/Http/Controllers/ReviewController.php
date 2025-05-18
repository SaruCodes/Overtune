<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function index()
    {
        $recentReviews = Review::with(['user', 'album'])
            ->withCount('comentarios')
            ->latest()
            ->paginate(5);

        $topAlbums = Album::withCount('review')
        ->orderByDesc('review_count')
            ->limit(5)
            ->get();

        $featuredReview = Review::with(['user', 'album'])
            ->withCount('comentarios')
            ->orderByDesc('comentarios_count')
            ->first();

        return view('review.index', compact('recentReviews', 'topAlbums', 'featuredReview'));
    }

    public function create()
    {
        $albums = Album::all();
        return view('review.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'rating' => 'required|numeric|min:0.5|max:5|multiple_of:0.5',
            'content' => 'required|string|min:100|max:2000'
        ]);

        $review = auth()->user()->reviews()->create($validated);

        return redirect()->route('review.show', $review)
            ->with('success', 'Reseña creada exitosamente!');
    }

    public function show(Review $review)
    {
        $review->load(['user', 'album', 'comentarios.user']);
        return view('review.show', compact('review'));
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
            'content' => 'required|string|min:100|max:2000'
        ]);

        $review->update($validated);

        return redirect()->route('review.show', $review)
            ->with('success', 'Reseña actualizada!');
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);
        $review->delete();
        return redirect()->route('reviews.index')
            ->with('success', 'Reseña eliminada!');
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
}
