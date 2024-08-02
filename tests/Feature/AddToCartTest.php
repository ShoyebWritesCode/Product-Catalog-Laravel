<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AddToCartTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_add_to_cart_when_logged_in(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Log in the user
        $this->actingAs($user);

        // Perform the action (e.g., add an item to the cart)
        $response = $this->post('/cart/add', [
            'product_id' => 1, // Replace with an actual product ID
            'quantity' => 1,
        ]);

        // Assert that the response is successful
        $response->assertStatus(200);

        // Optionally, assert that the item was added to the cart
        // This assumes you have a way to check the cart contents
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => 1,
            'quantity' => 1,
        ]);
    }

    /**
     * Test that a user cannot add to the cart when not logged in.
     */
    public function test_user_cannot_add_to_cart_when_not_logged_in(): void
    {
        // Perform the action without logging in
        $response = $this->post('/cart/add', [
            'product_id' => 1, // Replace with an actual product ID
            'quantity' => 1,
        ]);

        // Assert that the response is a redirect to the login page
        $response->assertRedirect('/login'); // Adjust the redirect path as necessary
    }
}
