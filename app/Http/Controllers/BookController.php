<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $category = $request->category;

        $categories = DB::table('categories')->get();
        $authors = DB::table('authors')->get();

        $books = DB::table('books as b')
            ->leftJoin('authors as a', 'a.id', '=', 'b.author_id')
            ->leftJoin('categories as c', 'c.id', '=', 'b.category_id')
            ->select(
                'b.id',
                'b.title',
                'b.isbn',
                'b.quantity',
                'b.image',
                'a.name as author',
                'c.name as category'
            )
            ->when($search, function ($query) use ($search) {
                $query->where('b.title', 'like', "%$search%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('b.category_id', $category);
            })
            ->orderByDesc('b.id')
            ->get();

                            $editBook = null;

                if ($request->has('edit')) {
                    $editBook = Book::find($request->edit);
                }

        return view('admin.books', compact('books', 'categories', 'authors', 'search', 'category','editBook'));
    }

    public function destroy($id)
{
    $book = Book::findOrFail($id);

    // delete image if exists
    if ($book->image && file_exists(public_path('uploads/books/'.$book->image))) {
        unlink(public_path('uploads/books/'.$book->image));
    }

    $book->delete();

    return redirect()->route('books.index');
}

public function update(Request $request, $id)
{
    $book = Book::findOrFail($id);

    $imageName = $book->image;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $imageName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/books'), $imageName);
    }

    $book->update([
        'title' => $request->title,
        'author_id' => $request->author_id,
        'category_id' => $request->category_id,
        'isbn' => $request->isbn,
        'quantity' => $request->quantity,
        'image' => $imageName
    ]);

    return redirect()->route('books.index');
}


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'isbn' => 'nullable',
            'image' => 'nullable|image'
        ]);

        $imageName = null;

        

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/books'), $imageName);
        }

        
        
        Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'isbn' => $request->isbn,
            'quantity' => $request->quantity,
            'image' => $imageName
        ]);

        return redirect()->route('books.index');
    }
}