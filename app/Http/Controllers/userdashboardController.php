<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    
public function myBooks()
{
    $user_id = Auth::id();

    $member = DB::table('members')
        ->where('user_id', $user_id)
        ->first();

if (!$member) {
        return redirect()->route('landing')->with('error', 'Your account is not registered as a member yet. Please contact admin.');
    }

    $rows = DB::table('book_issues as bi')
        ->join('books as b', 'b.id', '=', 'bi.book_id')
        ->where('bi.member_id', $member->id)
        ->select(
            'b.title',
            'b.isbn',
            'bi.issue_date',
            'bi.due_date',
            'bi.return_date',
            'bi.status',
            DB::raw('COALESCE(bi.fine,0) as fine')
        )
        ->orderByDesc('bi.id')
        ->get();

    return view('user.mybooks', compact('rows'));
}

    public function index(Request $request)
    {
        
        $user_id = Auth::id();

        // get member
        $member = DB::table('members')
            ->where('user_id', $user_id)
            ->first();
        if (!$member) {
            return redirect()->route('landing')->with('error', 'Your account is not registered as a member yet. Please contact admin.');
        }

        $member_id = $member->id;

        // stats
        $totalBorrowed = DB::table('book_issues')
            ->where('member_id', $member_id)
            ->count();

        $totalIssued = DB::table('book_issues')
            ->where('member_id', $member_id)
            ->where('status', 'issued')
            ->count();

        $totalReturned = DB::table('book_issues')
            ->where('member_id', $member_id)
            ->where('status', 'returned')
            ->count();

        // recent books
        $recent = DB::table('book_issues as bi')
            ->join('books as b', 'b.id', '=', 'bi.book_id')
            ->where('bi.member_id', $member_id)
            ->select('b.title', 'bi.issue_date', 'bi.status')
            ->orderByDesc('bi.id')
            ->limit(5)
            ->get();

        // search
        $search = $request->input('search');
        $books = collect(); // safer than []

        if ($search) {
            $books = DB::table('books as b')
                ->join('authors as a', 'a.id', '=', 'b.author_id')
                ->where(function ($q) use ($search) {
                    $q->where('b.title', 'like', "%$search%")
                      ->orWhere('a.name', 'like', "%$search%");
                })
                ->select('b.title', 'a.name as author', 'b.quantity')
                ->get();
        }

        return view('user.dashboard', compact(
            'totalBorrowed',
            'totalIssued',
            'totalReturned',
            'recent',
            'search',
            'books'
        ));
    }
    public function profile()
{
    $user = Auth::user();

    return view('user.profile', compact('user'));
}
}