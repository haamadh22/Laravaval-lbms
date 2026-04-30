<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    // User factory
    public function test_user_can_be_created_with_factory()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    // Admin factory
    public function test_admin_factory()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertEquals('admin', $admin->role);
    }

    // Multiple users factory
    public function test_create_multiple_users()
    {
        User::factory()->count(5)->create();

        $this->assertDatabaseCount('users', 5);
    }

    // Book factory
    public function test_book_can_be_created_with_factory()
    {
        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', ['id' => $book->id]);
    }

    // Member factory
    public function test_member_can_be_created_with_factory()
    {
        $member = Member::factory()->create();

        $this->assertDatabaseHas('members', ['id' => $member->id]);
    }
}