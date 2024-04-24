<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    // use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $admin = User::where('email', 'casalaguia@example.com')->first();


        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => env('USER_PASSWORD'),
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_admin_cannot_authenticate_with_invalid_password(): void
    {
        $admin = User::where('email', 'casalaguia@example.com')->first();
    
        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ]);
    
        $this->assertGuest();
    }
    
    public function test_admin_cannot_logout(): void
    {
        $admin = User::where('email', 'casalaguia@example.com')->first();
    
        $response = $this->actingAs($admin)->post('/logout');
    
        $this->assertGuest();
    
        $response->assertStatus(200);
    }
    
}
