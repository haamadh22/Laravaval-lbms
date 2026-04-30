<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorCategoryTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin()
    {
        return User::factory()->create(['role' => 'admin']);
    }


        //  AUTHOR TESTS

    public function test_admin_can_view_authors_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/authors');

        $response->assertStatus(200);
        $response->assertViewIs('admin.authors');
    }

    public function test_admin_can_create_author()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/authors', [
            'name' => 'New Author',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('authors', ['name' => 'New Author']);
    }

    public function test_admin_can_update_author()
    {
        $admin  = $this->createAdmin();
        $author = Author::create(['name' => 'Old Author']);

        $response = $this->actingAs($admin)->put("/admin/authors/{$author->id}", [
            'name' => 'Updated Author',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('authors', ['name' => 'Updated Author']);
    }

    public function test_admin_can_delete_author()
    {
        $admin  = $this->createAdmin();
        $author = Author::create(['name' => 'Delete Author']);

        $response = $this->actingAs($admin)->delete("/admin/authors/{$author->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }

    // CATEGORY TESTS

    public function test_admin_can_view_categories_page()
    {
        $admin    = $this->createAdmin();
        $response = $this->actingAs($admin)->get('/admin/categories');

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories');
    }

    public function test_admin_can_create_category()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'New Category',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    public function test_admin_can_update_category()
    {
        $admin    = $this->createAdmin();
        $category = Category::create(['name' => 'Old Category']);

        $response = $this->actingAs($admin)->put("/admin/categories/{$category->id}", [
            'name' => 'Updated Category',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    public function test_admin_can_delete_category()
    {
        $admin    = $this->createAdmin();
        $category = Category::create(['name' => 'Delete Category']);

        $response = $this->actingAs($admin)->delete("/admin/categories/{$category->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}