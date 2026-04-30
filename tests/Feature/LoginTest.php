<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_user_can_login_with_correct_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email'    => $user->email,    
            'password' => 'password',      
        ]);

        $this->assertAuthenticatedAs($user);
    }


    public function test_user_cannot_login_with_wrong_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
    }

    
    public function test_admin_can_access_admin_panel()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    
    public function test_member_cannot_access_admin_panel()
    {
        $member = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($member)->get('/admin/dashboard');

        $response->assertStatus(403);
    }
}