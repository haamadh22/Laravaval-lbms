<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Member;
use App\Models\BookIssue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookIssueTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_issue_has_correct_fillable_fields()
    {
        $issue = new BookIssue();

        $expected = [
            'book_id', 'member_id', 'issue_date',
            'due_date', 'return_date', 'status', 'fine'
        ];

        $this->assertEquals($expected, $issue->getFillable());
    }

    public function test_book_issue_uses_correct_table()
    {
        $issue = new BookIssue();

        $this->assertEquals('book_issues', $issue->getTable());
    }


    public function test_book_issue_can_be_created()
    {
        $book   = Book::factory()->create();
        $member = Member::factory()->create();

        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

        $this->assertDatabaseHas('book_issues', [
            'book_id'   => $book->id,
            'member_id' => $member->id,
            'status'    => 'issued',
        ]);
    }

    public function test_book_issue_belongs_to_book()
    {
        $book   = Book::factory()->create(['title' => 'Laravel Book']);
        $member = Member::factory()->create();

        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

        $this->assertEquals('Laravel Book', $issue->book->title);
    }

    public function test_book_issue_belongs_to_member()
    {
        $book   = Book::factory()->create();
        $member = Member::factory()->create(['membership_no' => 'MBR001']);

        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

        $this->assertEquals('MBR001', $issue->member->membership_no);
    }

    public function test_book_issue_status_can_be_updated_to_returned()
    {
        $book   = Book::factory()->create();
        $member = Member::factory()->create();

        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

        $issue->update([
            'status'      => 'returned',
            'return_date' => now()->toDateString(),
            'fine'        => 0,
        ]);

        $this->assertDatabaseHas('book_issues', [
            'id'     => $issue->id,
            'status' => 'returned',
        ]);
    }
}