<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $query = strtolower($request->input('q'));
        $albums = Album::whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])->get();
        $artists =Artist::whereRaw('LOWER(name) LIKE ?', ["%{$query}%"])->get();
        return view('search.results', ['albums' => $albums, 'artists' => $artists, 'query' => $request->input('q'),]);
    }

}
