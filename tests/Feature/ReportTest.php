<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * Test get my reports
     */
    public function testGetMyReports()
    {
        $user = User::create([
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2,
        ]);

        $this->actingAs($user, 'api');

        User::factory()->count(5)->create();

        $response = $this->getJson('/api/reports');

        $response->assertJson([
            'success' => true,
            'message' => 'Reports retrieved successfully',
            'data' => [],
        ]);
    }

    /**
     * Test send report
     */
    public function testSendReport()
    {
        UserType::factory()->count(2)->create();

        $user = User::create([
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 1,
        ]);

        User::factory()->create([
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/reports', [
            'type' => 'feedback',
            'reason' => 'Hello',
            'staff_id' => 2,
        ]);

        $response->assertJson([
            'success' => true,
            'message' => 'Reported successfully',
            'data' => [],
        ]);
    }
}
