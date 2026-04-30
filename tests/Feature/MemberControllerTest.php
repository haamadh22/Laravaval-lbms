<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    // =============================================
    // Helper — Admin create
    // =============================================
    private function createAdmin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    // =============================================
    // 1. INDEX — Members list பார்க்க
    // =============================================
    public function test_admin_can_view_members_list()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get('/admin/members');

        $response->assertStatus(200);
        $response->assertViewIs('admin.members');
    }

    // =============================================
    // 2. CREATE — Create page பார்க்க
    // =============================================
    public function test_admin_can_view_create_member_page()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->get('/admin/members/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.create-member');
    }

    // =============================================
    // 3. STORE — Existing user-ஐ member ஆக்க
    // =============================================
    public function test_admin_can_add_existing_user_as_member()
    {
        $admin = $this->createAdmin();
        $user  = User::factory()->create(['role' => 'member']);

        $response = $this->actingAs($admin)->post('/admin/members', [
            'user_id'       => $user->id,
            'membership_no' => 'MBR001',
        ]);

        $response->assertRedirect(route('members.index'));

        $this->assertDatabaseHas('members', [
            'user_id'       => $user->id,
            'membership_no' => 'MBR001',
        ]);
    }

    public function test_store_fails_without_user_id()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/members', [
            'user_id'       => '',
            'membership_no' => 'MBR001',
        ]);

        $response->assertSessionHasErrors(['user_id']);
    }

    public function test_store_fails_with_duplicate_membership_no()
    {
        $admin   = $this->createAdmin();
        $member  = Member::factory()->create(['membership_no' => 'MBR001']);
        $newUser = User::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/members', [
            'user_id'       => $newUser->id,
            'membership_no' => 'MBR001', // Already exists!
        ]);

        $response->assertSessionHasErrors(['membership_no']);
    }

    // =============================================
    // 4. REGISTER — New user create + member ஆக்க
    // =============================================
    public function test_admin_can_register_new_member()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/members/register', [
            'username' => 'newmember',
            'email'    => 'newmember@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('members.index'));

        // User create ஆச்சா?
        $this->assertDatabaseHas('users', [
            'username' => 'newmember',
            'email'    => 'newmember@test.com',
        ]);

        // Member create ஆச்சா?
        $user = User::where('username', 'newmember')->first();
        $this->assertDatabaseHas('members', [
            'user_id' => $user->id,
        ]);
    }

    public function test_register_fails_with_short_password()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post('/admin/members/register', [
            'username' => 'newmember',
            'email'    => 'new@test.com',
            'password' => '123', // Too short!
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_register_fails_with_duplicate_email()
    {
        $admin = $this->createAdmin();
        User::factory()->create(['email' => 'existing@test.com']);

        $response = $this->actingAs($admin)->post('/admin/members/register', [
            'username' => 'another',
            'email'    => 'existing@test.com', // Already taken!
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    // =============================================
    // 5. EDIT — Edit page பார்க்க
    // =============================================
    public function test_admin_can_view_edit_member_page()
    {
        $admin  = $this->createAdmin();
        $member = Member::factory()->create();

        $response = $this->actingAs($admin)->get("/admin/members/{$member->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.member-edit');
    }

    // =============================================
    // 6. UPDATE — Member update பண்ண
    // =============================================
    public function test_admin_can_update_member()
    {
        $admin  = $this->createAdmin();
        $member = Member::factory()->create();

        $response = $this->actingAs($admin)->put("/admin/members/{$member->id}", [
            'username'      => 'updatedname',
            'email'         => 'updated@test.com',
            'membership_no' => 'MBR999',
        ]);

        $response->assertRedirect(route('members.index'));

        $this->assertDatabaseHas('members', [
            'id'            => $member->id,
            'membership_no' => 'MBR999',
        ]);
    }

    // =============================================
    // 7. DESTROY — Member delete பண்ண
    // =============================================
    public function test_admin_can_delete_member()
    {
        $admin  = $this->createAdmin();
        $member = Member::factory()->create();

        $memberId = $member->id;
        $userId   = $member->user_id;

        $response = $this->actingAs($admin)
                         ->delete("/admin/members/{$memberId}");

        $response->assertRedirect(route('members.index'));

        // Member delete ஆச்சா?
        $this->assertDatabaseMissing('members', ['id' => $memberId]);

        // User delete ஆச்சா?
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}