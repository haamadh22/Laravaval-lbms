<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    // =============================================
    // 1. LOGIN
    // =============================================

    public function test_login_page_loads()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
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

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // =============================================
    // 2. PASSWORD UPDATE
    // =============================================

    public function test_password_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password'      => 'password',
                'password'              => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('newpassword123', $user->refresh()->password));
    }

    public function test_wrong_current_password_cannot_update()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password'      => 'wrongpassword',
                'password'              => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertSessionHasErrorsIn('updatePassword', 'current_password');
    }

    // =============================================
    // 3. PASSWORD RESET
    // =============================================

    public function test_password_reset_link_screen_loads()
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
    }

    public function test_password_reset_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token'                 => $notification->token,
                'email'                 => $user->email,
                'password'              => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

            $response->assertSessionHasNoErrors();
            return true;
        });
    }

    // =============================================
    // 4. EMAIL VERIFICATION
    // =============================================

    public function test_email_verification_screen_loads()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    // =============================================
    // 5. PASSWORD CONFIRM
    // =============================================

    public function test_confirm_password_screen_loads()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_wrong_password_cannot_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
    }
          
        public function test_register_page_loads()
        {
            $response = $this->get('/register');
            $response->assertStatus(200);
        }

       
        public function test_new_user_can_register()
        {
            $response = $this->post('/register', [
                'username'              => 'newuser',
                'email'                 => 'newuser@test.com',
                'password'              => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $this->assertAuthenticated();
            $this->assertDatabaseHas('users', [
                'email' => 'newuser@test.com',
            ]);
        }
}