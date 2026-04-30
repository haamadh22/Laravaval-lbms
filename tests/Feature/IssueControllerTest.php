<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use App\Models\BookIssue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    // =============================================
    // 1. INDEX — Issue page பார்க்க
    // =============================================
    public function test_admin_can_view_issue_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/book-issue');

        $response->assertStatus(200);
        $response->assertViewIs('admin.issue');
    }

    // =============================================
    // 2. STORE — Book issue பண்ண
    // =============================================
    public function test_admin_can_issue_book_to_member()
    {
        $admin  = $this->createAdmin();
        $book   = Book::factory()->create(['quantity' => 5]);
        $member = Member::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/book-issue', [
            'book_id'   => $book->id,
            'member_id' => $member->id,
        ]);

        $response->assertRedirect(route('issue.book'));

        // BookIssue record create ஆச்சா?
        $this->assertDatabaseHas('book_issues', [
            'book_id'   => $book->id,
            'member_id' => $member->id,
            'status'    => 'issued',
        ]);

        // Quantity குறைஞ்சுதா?
        $this->assertDatabaseHas('books', [
            'id'       => $book->id,
            'quantity' => 4,
        ]);
    }

    public function test_issue_fails_with_invalid_book()
    {
        $admin  = $this->createAdmin();
        $member = Member::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/book-issue', [
            'book_id'   => 99999, // Doesn't exist!
            'member_id' => $member->id,
        ]);

        $response->assertSessionHasErrors(['book_id']);
    }

    public function test_issue_fails_with_invalid_member()
    {
        $admin = $this->createAdmin();
        $book  = Book::factory()->create(['quantity' => 3]);

        $response = $this->actingAs($admin)->post('/admin/book-issue', [
            'book_id'   => $book->id,
            'member_id' => 99999, // Doesn't exist!
        ]);

        $response->assertSessionHasErrors(['member_id']);
    }

    // =============================================
    // 3. RETURN INDEX — Return page பார்க்க
    // =============================================
    public function test_admin_can_view_return_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/return-book');

        $response->assertStatus(200);
        $response->assertViewIs('admin.return');
    }

    // =============================================
    // 4. RETURN STORE — Book return பண்ண
    // =============================================
    public function test_admin_can_return_book()
    {
        $admin  = $this->createAdmin();
        $book   = Book::factory()->create(['quantity' => 4]);
        $member = Member::factory()->create();

        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->toDateString(),
            'due_date'   => now()->addDays(7)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

        $response = $this->actingAs($admin)->post('/admin/return-book', [
            'return_id' => $issue->id,
        ]);

        $response->assertRedirect(route('return.book'));

        // Status returned ஆச்சா?
        $this->assertDatabaseHas('book_issues', [
            'id'     => $issue->id,
            'status' => 'returned',
        ]);

        // Quantity கூடுச்சா?
        $this->assertDatabaseHas('books', [
            'id'       => $book->id,
            'quantity' => 5,
        ]);
    }

    public function test_overdue_return_has_fine()
    {
        $admin  = $this->createAdmin();
        $book   = Book::factory()->create(['quantity' => 3]);
        $member = Member::factory()->create();

        // 3 days overdue
        $issue = BookIssue::create([
            'book_id'    => $book->id,
            'member_id'  => $member->id,
            'issue_date' => now()->subDays(10)->toDateString(),
            'due_date'   => now()->subDays(3)->toDateString(),
            'status'     => 'issued',
            'fine'       => 0,
        ]);

        $this->actingAs($admin)->post('/admin/return-book', [
            'return_id' => $issue->id,
        ]);

        // Fine > 0 ஆச்சா? (3 days × Rs.50 = Rs.150)
        $updated = BookIssue::find($issue->id);
        $this->assertGreaterThan(0, $updated->fine);
    }

    // =============================================
    // 5. ISSUED BOOKS PAGE
    // =============================================
    public function test_admin_can_view_issued_books_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/issued-books');

        $response->assertStatus(200);
        $response->assertViewIs('admin.issued');
    }

    // =============================================
    // 6. HISTORY PAGE
    // =============================================
    public function test_admin_can_view_borrow_history_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/borrow-history');

        $response->assertStatus(200);
        $response->assertViewIs('admin.history');
    }
}