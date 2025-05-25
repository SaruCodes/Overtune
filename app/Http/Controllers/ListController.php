<?php

namespace App\Http\Controllers;

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
        $popularLists = ListModel::orderBy('views', 'desc')->take(8)->get();

        return view('lists.index', compact('lists', 'latestLists', 'recommendedLists', 'popularLists'));
    }

    public function create()
    {
        return view('lists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $list = ListModel::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('lists.show', $list->id)->with('success', 'Lista creada correctamente.');
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
}
