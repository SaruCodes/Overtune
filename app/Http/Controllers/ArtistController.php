<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::query();

        if ($request->filled('debut')) {
            $debut = (int) $request->debut;
            if ($debut % 10 === 0) {
                $query->where('debut', '>=', $debut)
                    ->where('debut', '<', $debut + 10);
            } else {
                $query->where('debut', $debut);
            }
        }
        $artists = $query->orderByDesc('id')->paginate(10);
        $artists80 = Artist::where('debut', '>=', 1980)->where('debut', '<', 1990)->orderByDesc('id')->take(10)->get();

        return view('artists.index', compact('artists', 'artists80'));
    }

    public function crud(Request $request)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isEditor()) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
        $query = Artist::query();

        if ($request->filled('debut')) {
            $query->where('debut', $request->debut);
        }

        $artists = $query->orderByDesc('id')->paginate(10);
        return view('artists.crud', compact('artists'));
    }

    public function create()
    {
        return view('artists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'bio'     => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'debut'   => 'nullable|integer',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        Artist::create($validated);

        return redirect()->route('artists.crud')->with('success', 'Artista creado correctamente.');
    }

    public function show(Artist $artist)
    {
        return view('artists.show', compact('artist'));
    }

    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'debut' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        $artist->update($validated);

        return redirect()->route('artists.crud')->with('success', 'Artista actualizado correctamente.');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('artists.crud')->with('success', 'Artista eliminado correctamente.');
    }
}

