<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_cannot_be_created_without_title()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_book_cannot_be_created_without_author()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'     => 'Some Book',
            'author_id' => '',
        ]);

        $response->assertSessionHasErrors(['author_id']);
    }

    
    public function test_book_cannot_be_created_without_quantity()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'    => 'Some Book',
            'quantity' => '',
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }


    public function test_book_can_be_created_with_all_valid_fields()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book  = Book::factory()->make();

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'       => $book->title,
            'author_id'   => $book->author_id,
            'category_id' => $book->category_id,
            'quantity'    => $book->quantity,
            'isbn'        => $book->isbn,
        ]);

        $response->assertRedirect(route('books.index'));

        $this->assertDatabaseHas('books', [
            'title' => $book->title,
        ]);
    }
}