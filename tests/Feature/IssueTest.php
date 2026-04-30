<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueTest extends TestCase
{
    use RefreshDatabase;

    public function test_issuing_a_book_reduces_quantity_by_one()
    {

        $admin  = User::factory()->create(['role' => 'admin']);
        $book   = Book::factory()->create(['quantity' => 5]);
        $member = Member::factory()->create();

        $this->actingAs($admin)->post('/admin/book-issue', [
            'book_id'   => $book->id,
            'member_id' => $member->id,
        ]);

        
        $this->assertDatabaseHas('books', [
            'id'       => $book->id,
            'quantity' => 4,
        ]);
    }
}