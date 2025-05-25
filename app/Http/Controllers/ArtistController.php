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
            $query->where('debut', $request->debut);
        }

        $artists = $query->orderByDesc('id')->paginate(10);
        return view('artists.index', compact('artists'));
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

        return redirect()->route('artists.index')->with('success', 'Artista creado correctamente.');
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
            'name'    => 'required|string|max:255',
            'bio'     => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'debut'   => 'nullable|integer',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        $artist->update($validated);

        return redirect()->route('artists.index')->with('success', 'Artista actualizado correctamente.');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('artists.index')->with('success', 'Artista eliminado correctamente.');
    }
}
