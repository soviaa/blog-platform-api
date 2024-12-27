<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase

{

    public function test_user_login(): void
    {
        $response = $this->postJson('/user/register',[
            'username' => 'testuser',
            'email' => 'user@example.com',
            'password'=> 'password',
        ]);
        $response->dump();
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'User registered successfully',
        ]);

    }
}
