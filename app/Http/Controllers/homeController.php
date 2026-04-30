<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $categories = DB::table('categories')
            ->orderBy('name')
            ->get();

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
            );

        if ($search) {
            $books->where(function ($q) use ($search) {
                $q->where('b.title', 'like', "%$search%")
                  ->orWhere('a.name', 'like', "%$search%");
            });
        }

        if ($category) {
            $books->where('b.category_id', $category);
        }

        $books = $books->orderByDesc('b.id')->get();

        return view('welcome', compact('books', 'categories', 'search', 'category'));
    }
    public function show($id)
{
    $book = \App\Models\Book::with(['author', 'category'])->findOrFail($id);
    return view('book-detail', compact('book'));
}
}
