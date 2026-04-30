<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::latest()->get();
        return view('admin.authors', compact('authors'));
    }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:authors,name|max:255'
    ]);

    Author::create([
        'name' => $request->name
    ]);

    return redirect()->back()->with('success', 'Author added successfully!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:authors,name,' . $id . '|max:255'
    ]);

    $author = Author::findOrFail($id);
    $author->update([
        'name' => $request->name
    ]);

    return redirect()->back()->with('success', 'Author updated successfully!');
}

    public function destroy($id)
    {
        Author::findOrFail($id)->delete();
        return redirect()->back();
    }
}