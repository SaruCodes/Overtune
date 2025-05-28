<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request, $type, $id)
    {
        $user = auth()->user();

        $modelClass = match ($type) {
            'album' => Album::class,
            'lista' => ListModel::class,
            'artist' => Artist::class,
            default => null,
        };

        if (!$modelClass) {
            abort(404);
        }

        $model = $modelClass::findOrFail($id);

        $existing = $user->favorites()
            ->where('favoritable_type', $modelClass)
            ->where('favoritable_id', $model->id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $user->favorites()->create([
                'favoritable_id' => $model->id,
                'favoritable_type' => $modelClass,
            ]);
        }

        return back();
    }
}
