<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BookIssue;


class IssueController extends Controller
{
    /* ================= ISSUE INDEX ================= */
    public function index()
    {
        $books = DB::table('books')
            ->where('quantity', '>', 0)
            ->select('id', 'title', 'quantity')
            ->get();

        $members = DB::table('members as m')
            ->join('users as u', 'm.user_id', '=', 'u.id')
            ->select('m.id', 'u.username', 'm.membership_no')
            ->get();

        return view('admin.issue', compact('books', 'members'));
    }

    /* ================= ISSUE STORE ================= */
    public function store(Request $request)
    {
        $request->validate([
            'book_id'   => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
        ]);

        DB::transaction(function () use ($request) {
            BookIssue::create([
                'book_id'    => $request->book_id,
                'member_id'  => $request->member_id,
                'issue_date' => now()->toDateString(),
                'due_date'   => now()->addDays(7)->toDateString(),
                'status'     => 'issued',
                'fine'       => 0.00,
            ]);

            DB::table('books')
                ->where('id', $request->book_id)
                ->decrement('quantity');
        });

        return redirect()->route('issue.book')->with('success', 'Book issued successfully!');
    }

    /* ================= RETURN INDEX ================= */
    public function returnIndex()
    {
        $issues = DB::table('book_issues as bi')
            ->join('books as b',   'bi.book_id',   '=', 'b.id')
            ->join('members as m', 'bi.member_id', '=', 'm.id')
            ->join('users as u',   'm.user_id',    '=', 'u.id')
            ->where('bi.status', 'issued')
            ->select(
                'bi.id as issue_id',
                'b.title',
                'u.username',
                'bi.issue_date',
                'bi.due_date'
            )
            ->get();

        return view('admin.return', compact('issues'));
    }

    /* ================= RETURN STORE ================= */
    public function returnStore(Request $request)
    {
        $request->validate([
            'return_id' => 'required|exists:book_issues,id',
        ]);

        $issue = BookIssue::findOrFail($request->return_id);

        $returnDate  = now()->toDateString();
        $finePerDay  = 50;
        $overdueDays = max(0, now()->startOfDay()->diffInDays($issue->due_date, false) * -1);
        $fine        = $overdueDays * $finePerDay;

        DB::transaction(function () use ($issue, $returnDate, $fine) {
            $issue->update([
                'status'      => 'returned',
                'return_date' => $returnDate,
                'fine'        => $fine,
            ]);

            DB::table('books')
                ->where('id', $issue->book_id)
                ->increment('quantity');
        });

        $msg = $fine > 0
            ? "Book returned successfully! Fine: Rs.$fine"
            : "Book returned successfully!";

        return redirect()->route('return.book')->with('success', $msg);
    }

    public function issuedBooks()
{
    $issuedBooks = BookIssue::with(['book', 'member.user'])
        ->latest()
        ->get();

    return view('admin.issued', compact('issuedBooks'));
}
public function history()
{
    $history = DB::table('book_issues as bi')
        ->join('members as m', 'bi.member_id', '=', 'm.id')
        ->join('users as u',   'm.user_id',    '=', 'u.id')
        ->join('books as b',   'bi.book_id',   '=', 'b.id')
        ->select(
            'u.username',
            'b.title',
            'bi.issue_date',
            'bi.return_date',
            'bi.status',
            'bi.fine'
        )
        ->orderBy('bi.id', 'desc')
        ->get();

    return view('admin.history', compact('history'));
}
}