<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->latest()->paginate(10);
        return view('albums.crud', compact('albums'));
    }

    public function create()
    {
        $artists = Artist::all();
        return view('albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_date' => 'required|date',
            'cover_image' => 'nullable|url',
            'description' => 'nullable|string',
            'type' => 'required|in:Album,EP,Single',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);


        $albumData = $validated;
        unset($albumData['genres']);
        $album = Album::create($albumData);

        $album->genres()->sync($validated['genres']);
        return redirect()->route('albums.crud')->with('success', 'Álbum creado correctamente.');
    }

    public function edit(Album $album)
    {
        $artists = Artist::all();
        return view('albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_date' => 'required|date',
            'cover_image' => 'nullable|url',
            'description' => 'nullable|string',
            'type' => 'required|in:Album,EP,Single',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $albumData = $validated;
        unset($albumData['genres']);

        $album->update($albumData);
        $album->genres()->sync($validated['genres']);
        return redirect()->route('albums.crud')->with('success', 'Álbum actualizado correctamente.');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albums.crud')->with('success', 'Álbum eliminado.');
    }
}
