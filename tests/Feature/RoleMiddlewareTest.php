<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    // =============================================
    // 1. LOGIN இல்லாம access பண்ண முடியாது
    // =============================================
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    // =============================================
    // 2. Admin role — admin page access ✅
    // =============================================
    public function test_admin_can_access_admin_routes()
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    // =============================================
    // 3. Member role — admin page access ❌
    // =============================================
    public function test_member_cannot_access_admin_routes()
    {
        $member   = User::factory()->create(['role' => 'member']);
        $response = $this->actingAs($member)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    // =============================================
    // 4. Member role — member page access ✅
    // =============================================
    public function test_member_can_access_member_routes()
    {
        $member = Member::factory()->create();
        $member->user->update(['role' => 'member']);

        $response = $this->actingAs($member->user)->get('/member/dashboard');

        $response->assertStatus(200);
    }

    // =============================================
    // 5. Admin role — member page access ❌
    // =============================================
    public function test_admin_cannot_access_member_routes()
    {
        $admin    = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/member/dashboard');

        $response->assertStatus(302);
    }

    // =============================================
    // 6. Wrong role — redirect ஆகுது
    // =============================================
    public function test_wrong_role_is_redirected()
    {
        $user     = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($user)->get('/admin/dashboard');

        // Wrong role → 403 வரணும்
        $response->assertStatus(403);
    }
}