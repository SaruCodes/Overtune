<?php

namespace App\Http\Controllers;

use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($listId)
    {
        $user = Auth::user();
        $list = ListModel::findOrFail($listId);

        if ($user->favoriteLists()->where('list_id', $list->id)->exists()) {
            $user->favoriteLists()->detach($list);
        } else {
            $user->favoriteLists()->attach($list);
        }

        return back();
    }
}
