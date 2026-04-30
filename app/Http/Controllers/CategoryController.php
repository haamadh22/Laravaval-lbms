<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories,name|max:255'
    ]);

    Category::create([
        'name' => $request->name
    ]);

    return redirect()->back()->with('success', 'Category added successfully!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:categories,name,' . $id . '|max:255'
    ]);

    Category::findOrFail($id)->update([
        'name' => $request->name
    ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back();
    }
}