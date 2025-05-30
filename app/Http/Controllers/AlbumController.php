<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('artist')->latest()->paginate(10);
        return view('albums.crud', compact('albums'));
    }

    public function crud()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isEditor()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        $albums = Album::with('artist')->latest()->paginate(10);
        return view('albums.crud', compact('albums'));
    }

    public function create()
    {
        $artists = Artist::all();
        $genres = Genre::all();

        return view('albums.create', compact('artists', 'genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_date' => 'required|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'type' => 'required|in:Album,EP,Single',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id'
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('album-covers', 'public');
            $validated['cover_image'] = $path;
        }

        $album = Album::create([
            'title' => $validated['title'],
            'artist_id' => $validated['artist_id'],
            'release_date' => $validated['release_date'],
            'cover_image' => $validated['cover_image'] ?? 'images/placeholders/album.png',
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
        ]);

        $album->genres()->sync($validated['genres']);

        return redirect()->route('albums.crud')->with('success', 'Álbum creado exitosamente!');
    }

    public function edit(Album $album)
    {
        $artists = Artist::all();
        $genres = Genre::all();
        return view('albums.edit', compact('album', 'artists', 'genres'));
    }


    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'release_date' => 'required|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'type' => 'required|in:Album,EP,Single',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $album->cover_image);
            }

            $path = $request->file('cover_image')->store('album-covers', 'public');
            $validated['cover_image'] = $path;
        } else {
            unset($validated['cover_image']);
        }

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

    public function show($id, SpotifyService $spotify)
    {
        $album = Album::with(['artist', 'genres', 'review.user', 'review.comments'])->findOrFail($id);
        $recommendedAlbums = Album::where('id', '!=', $album->id)->where(function ($query) use ($album) {
            $query->where('artist_id', $album->artist_id)
                ->orWhereHas('genres', function ($q) use ($album) {
                    return $q->whereIn('genres.id', $album->genres->pluck('id'));
                });
        })->with('artist')->limit(5)->get();
        $spotifyAlbum = $spotify->searchAlbum($album->title, $album->artist->name);

        return view('albums.show', compact('album', 'recommendedAlbums', 'spotifyAlbum'));
    }

    public function search(Request $request)
    {
        $query = Album::query()->with(['artist', 'genres']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('year')) {
            $query->whereYear('release_date', $request->year);
        }

        if ($request->filled('genres')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->whereIn('genres.id', $request->genres);
            });
        }

        $albums = $query->get();
        $genres = Genre::all();

        return view('albums.search', compact('albums', 'genres'));
    }
}
