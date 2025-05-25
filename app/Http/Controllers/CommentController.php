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
            'commentable_type' => 'required|string|in:news,reviews',
            'commentable_id' => 'required|integer'
        ]);

        $modelClass = match ($request->commentable_type) {
            'news' => \App\Models\News::class,
            'reviews' => \App\Models\Review::class,
            default => abort(400, 'Tipo de comentario no soportado.'),
        };

        $commentable = $modelClass::findOrFail($request->commentable_id);
        $comment = new \App\Models\Comment(['content' => $request->content, 'user_id' => auth()->id(),]);
        $commentable->comments()->save($comment);
        return back()->with('success', 'Comentario publicado.');
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        if ($comment->user_id !== $user->id && !$user->hasRole('admin') && !$user->hasRole('editor')) {
            abort(403, 'No tienes permiso para actualizar este comentario.');
        }

        $comment->update([
            'content' => $request->input('content'),
        ]);
        return redirect()->back()->with('mensaje', 'Comentario actualizado correctamente.');
    }
    public function destroy(Comment $comment)
    {
        $user = auth()->user();
        if ($comment->user_id !== $user->id && !$user->hasRole('admin') && !$user->hasRole('editor')) {
            abort(403, 'No tienes permiso para eliminar este comentario.');
        }

        $comment->delete();
        return redirect()->back()->with('mensaje', 'Comentario eliminado correctamente.');
    }
}
