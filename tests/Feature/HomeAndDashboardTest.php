<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeAndDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_landing_page_shows_books()
    {
        $book     = Book::factory()->create(['title' => 'Laravel Book']);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Laravel Book');
    }

    public function test_book_detail_page_is_accessible()
    {
        $book     = Book::factory()->create();
        $response = $this->get("/books/{$book->id}");

        $response->assertStatus(200);
    }

    public function test_member_can_view_dashboard()
    {
        $member = Member::factory()->create();
        $member->user->update(['role' => 'member']);

        $response = $this->actingAs($member->user)->get('/member/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('user.dashboard');
    }

    public function test_member_can_view_my_books()
    {
        $member = Member::factory()->create();
        $member->user->update(['role' => 'member']);

        $response = $this->actingAs($member->user)->get('/member/my-books');

        $response->assertStatus(200);
        $response->assertViewIs('user.mybooks');
    }

    public function test_member_can_view_profile()
    {
        $member = Member::factory()->create();
        $member->user->update(['role' => 'member']);

        $response = $this->actingAs($member->user)->get('/member/profile');

        $response->assertStatus(200);
        $response->assertViewIs('user.profile');
    }

    public function test_guest_cannot_view_member_dashboard()
    {
        $response = $this->get('/member/dashboard');
        $response->assertRedirect('/login');
    }


    public function test_admin_role_can_access_admin_pages()
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_member_role_cannot_access_admin_pages()
    {
        $member   = User::factory()->create(['role' => 'member']);
        $response = $this->actingAs($member)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_admin_cannot_access_member_dashboard()
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/member/dashboard');

        $response->assertStatus(302);
    }
}