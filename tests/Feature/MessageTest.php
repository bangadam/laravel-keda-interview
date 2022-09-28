<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    /**
     * Test get my messages
     */
    public function testGetMyMessages()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 1,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/messages');

        $response->assertJson([
            'success' => true,
            'message' => 'Messages retrieved successfully',
            'data' => [],
        ]);
    }

    /**
     * Test send message
     */
    public function testSendMessage()
    {
        UserType::factory()->count(2)->create();

        $user = User::create([
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 1,
        ]);

        User::factory()->count(5)->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/messages', [
            'message' => 'Hello',
            'receiver_id' => 2,
        ]);

        $response->assertJson([
            'success' => true,
            'message' => 'Message sent successfully',
            'data' => [
                'message' => 'Hello',
                'receiver_id' => 1,
            ],
        ]);
    }
}
