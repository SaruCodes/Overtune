<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\ListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{

    public function index()
    {
        $lists = ListModel::where('user_id', Auth::id())->get();
        $latestLists = ListModel::latest()->take(10)->get();
        $recommendedLists = ListModel::inRandomOrder()->take(8)->get();
        $popularLists = ListModel::withCount('favorites')->orderBy('favorites_count', 'desc')->take(8)->get();

        return view('lists.index', compact('lists', 'latestLists', 'recommendedLists', 'popularLists'));
    }

    public function create(Request $request)
    {
        $query = $request->input('search');
        $albums = null;

        if ($query) {
            $albums = Album::where('title', 'like', '%' . $query . '%')->orderBy('title')->get();
        }

        return view('lists.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'albums' => 'required|array',
            'albums.*' => 'exists:albums,id',
        ]);

        $list = new \App\Models\ListModel();
        $list->title = $request->title;
        $list->description = $request->description;
        $list->user_id = auth()->id();
        $list->save();
        $list->albums()->sync($request->albums);
        session()->forget('selected_albums');
        session()->forget('form_data');

        return redirect()->route('lists.show', $list)->with('success', 'Lista creada correctamente');
    }


    public function show($id)
    {
        $list = ListModel::where('user_id', Auth::id())->findOrFail($id);
        return view('lists.show', compact('list'));
    }

    public function edit($id)
    {
        $list = ListModel::where('user_id', Auth::id())->findOrFail($id);
        return view('lists.edit', compact('list'));
    }

    public function update(Request $request, $id)
    {
        $list = ListModel::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $list->update($validated);

        return redirect()->route('lists.show', $list->id)->with('success', 'Lista actualizada.');
    }


    public function destroy($id)
    {
        $list = ListModel::where('user_id', Auth::id())->findOrFail($id);
        $list->delete();

        return redirect()->route('lists.index')->with('success', 'Lista eliminada.');
    }

    public function addAlbumTemp(Request $request)
    {
        $request->validate(['album_id' => 'required|exists:albums,id']);
        $selected = session('selected_albums', []);
        if (!in_array($request->album_id, $selected)) {
            $selected[] = $request->album_id;
            session(['selected_albums' => $selected]);
        }
        return redirect()->route('lists.create', ['search' => $request->input('search')]);
    }

    public function removeAlbumTemp(Request $request)
    {
        $request->validate(['album_id' => 'required|exists:albums,id']);
        $selected = session('selected_albums', []);
        $selected = array_filter($selected, fn($id) => $id != $request->album_id);
        session(['selected_albums' => $selected]);
        return redirect()->route('lists.create', ['search' => $request->input('search')]);
    }

}
