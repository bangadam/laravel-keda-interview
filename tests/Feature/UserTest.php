<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test failed authorize to get customers
     */
    public function testFailedAuthorizeToGetCustomers()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 1,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/users/customers');

        $response->assertJson([
            'success' => false,
            'message' => 'This action is unauthorized.',
        ]);
    }

    /**
     * Test empty get customers
     */
    public function testEmptyGetCustomers()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/users/customers');

        $response->assertJson([
            'success' => true,
            'message' => 'Users retrieved successfully',
            'data' => [],
        ]);
    }

    /**
     * Test get customers
     */
    public function testGetCustomers()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2,
        ]);
        $this->actingAs($user, 'api');

        User::factory()->count(5)->create();

        $response = $this->get('/api/users/customers');

        $response->assertJsonStructure(
            [
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'user_type_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]
        );
    }

    /**
     * Test failed delete customer
     */
    public function testFailedDeleteCustomer()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 1,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->deleteJson('/api/users/customers/1');

        $response->assertJson([
            'success' => false,
            'message' => 'This action is unauthorized.',
        ]);
    }

    /**
     * Test success delete customer
     */
    public function testSuccessDeleteCustomer()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
            'user_type_id' => 2,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->deleteJson('/api/users/customers/1');

        $response->assertJson([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
