<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    // GET /api/artists
    public function index()
    {
        return Artist::all();
    }

    // POST /api/artists
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'debut' => 'nullable|string|max:50',
            'image' => 'nullable|string'
        ]);

        $artist = Artist::create($data);
        return response()->json($artist, 201);
    }

    // GET /api/artists/{artist}
    public function show(Artist $artist)
    {
        return $artist;
    }

    // PUT/PATCH /api/artists/{artist}
    public function update(Request $request, Artist $artist)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'debut' => 'nullable|string|max:50',
            'image' => 'nullable|string'
        ]);

        $artist->update($data);
        return $artist;
    }

    // DELETE /api/artists/{artist}
    public function destroy(Artist $artist)
    {
        $artist->delete();
        return response()->json(null, 204);
    }
}
