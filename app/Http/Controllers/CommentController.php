<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'review_id' => 'required|exists:reviews,id'
        ]);

        $review = Review::findOrFail($request->review_id);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);

        $review->comments()->save($comment);

        return redirect()->back()->with('success', 'Comentario publicado.');
    }
}
