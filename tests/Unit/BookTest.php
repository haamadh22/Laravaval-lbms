<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_can_be_created()
    {

        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }
}