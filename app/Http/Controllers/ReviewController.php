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
            'content' => 'required|string|min:100|max:3000'
        ]);

        $review->update($validated);

        return redirect()->route('review.show', $review)
            ->with('success', 'Reseña actualizada!');
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);
        $review->delete();
        return redirect()->route('review.crud')
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
}
