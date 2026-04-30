<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin()
    {
        return User::factory()->create(['role' => 'admin']);
    }


    public function test_admin_can_view_books_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/books');

        $response->assertStatus(200);
        $response->assertViewIs('admin.books');
    }


    public function test_admin_can_create_book()
    {
        $admin = $this->createAdmin();
        $book  = Book::factory()->make(); 

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'       => $book->title,
            'author_id'   => $book->author_id,
            'category_id' => $book->category_id,
            'quantity'    => $book->quantity,
            'isbn'        => $book->isbn,
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => $book->title]);
    }

    public function test_book_creation_fails_without_title()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_book_creation_fails_without_author()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'     => 'Some Book',
            'author_id' => '',
        ]);

        $response->assertSessionHasErrors(['author_id']);
    }

    public function test_book_creation_fails_without_quantity()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/books', [
            'title'    => 'Some Book',
            'quantity' => '',
        ]);

        $response->assertSessionHasErrors(['quantity']);
    }


    public function test_admin_can_update_book()
    {
        $admin   = $this->createAdmin();
        $book    = Book::factory()->create();
        $newBook = Book::factory()->make();

        $response = $this->actingAs($admin)->put("/admin/books/{$book->id}", [
            'title'       => 'Updated Title',
            'author_id'   => $newBook->author_id,
            'category_id' => $newBook->category_id,
            'quantity'    => 10,
            'isbn'        => '999-888',
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', [
            'id'       => $book->id,
            'title'    => 'Updated Title',
            'quantity' => 10,
        ]);
    }


    public function test_admin_can_delete_book()
    {
        $admin = $this->createAdmin();
        $book  = Book::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/books/{$book->id}");

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_delete_nonexistent_book_returns_404()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->delete('/admin/books/99999');

        $response->assertStatus(404);
    }


    public function test_admin_can_search_books()
    {
        $admin = $this->createAdmin();
        $book  = Book::factory()->create(['title' => 'Laravel Guide']);

        $response = $this->actingAs($admin)->get('/admin/books?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Guide');
    }
}