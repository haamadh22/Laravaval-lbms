<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use App\Models\BookIssue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReturnTest extends TestCase
{
    use RefreshDatabase;

    public function test_returning_a_book_changes_status_to_returned()
    {
        $admin  = User::factory()->create(['role' => 'admin']);
        $book   = Book::factory()->create(['quantity' => 4]);
        $member = Member::factory()->create();

        // Issue record create
        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

       
        $this->actingAs($admin)->post('/admin/return-book', [
            'return_id' => $issue->id,
        ]);

        
        $this->assertDatabaseHas('book_issues', [
            'id'     => $issue->id,
            'status' => 'returned',
        ]);

       
        $this->assertDatabaseHas('books', [
            'id'       => $book->id,
            'quantity' => 5,
        ]);
    }
}