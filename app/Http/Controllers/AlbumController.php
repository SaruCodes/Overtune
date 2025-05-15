<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->latest()->paginate(10);
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        $artists = Artist::all();
        return view('albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'release_date' => 'required|date',
            'cover_image'  => 'nullable|image|max:2048',
            'description'  => 'nullable|string',
            'type'         => 'required|in:Album,EP,Single',
            'artist_id'    => 'required|exists:artists,id',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('albums', 'public');
        }

        Album::create($validated);

        return redirect()->route('albums.index')->with('success', 'Álbum creado correctamente.');
    }

    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $artists = Artist::all();
        return view('albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'release_date' => 'required|date',
            'cover_image'  => 'nullable|image|max:2048',
            'description'  => 'nullable|string',
            'type'         => 'required|in:Album,EP,Single',
            'artist_id'    => 'required|exists:artists,id',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('albums', 'public');
        }

        $album->update($validated);

        return redirect()->route('albums.index')->with('success', 'Álbum actualizado correctamente.');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Álbum eliminado correctamente.');
    }
}
