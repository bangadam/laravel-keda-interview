<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login with invalid validation
     */
    public function testLoginWithInvalidValidation()
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ],
        ]);
    }

    /**
     * Test login is successful
     */
    public function testLoginIsSuccessful()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'token',
            ],
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test Logout is failed
     */
    public function testLogoutIsFailed()
    {
        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer invalid-token',
        ]);

        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Token could not be parsed from the request.',
        ]);
    }

    /**
     * Test Logout is successful
     */
    public function testLogoutIsSuccessful()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logout successful',
        ]);

        $this->assertGuest();
    }
}
