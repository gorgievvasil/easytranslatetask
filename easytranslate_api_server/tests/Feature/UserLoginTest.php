<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $response = $this->postJson('/api/auth/login', ['email' => 'gjorgjiev.vasil@gmail.com', 'password' => 'Tremnik@#1']);

        $response->assertStatus(200)
                ->assertJson([
                    "status" => true,
                    "message" => "User login successful"
                ]);
    }
}
