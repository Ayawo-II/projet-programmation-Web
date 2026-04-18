<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('questions')->orderBy('name')->paginate(20);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50|unique:tags',
            'description' => 'nullable|string|max:255',
        ]);

        Tag::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag créé.');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name'        => 'required|string|max:50|unique:tags,name,' . $tag->id,
            'description' => 'nullable|string|max:255',
        ]);

        $tag->update([
            'name'        => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag mis à jour.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag supprimé.');
    }
}