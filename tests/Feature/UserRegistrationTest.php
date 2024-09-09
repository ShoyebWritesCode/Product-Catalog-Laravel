<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UserRegistrationTest extends TestCase
{
    /*public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/

    // use RefreshDatabase;

    public function testUserCanRegister()
    {
        $this->withoutMiddleware();
        $response = $this->post('/register', [
            'name' => 'Test Name',
            'email' => 'test@example.com',
            'password' => 'password1234',
            'password_confirmation' => 'password1234',
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
