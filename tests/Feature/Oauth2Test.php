<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Oauth2Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_oauth_client()
    {
        $user = User::firstOr(function () {
            return User::factory()->create();
        });
        $this->actingAs($user);
        $testResponse = $this->get('/oauth/clients', ['Accept' => 'application/json']);
        $testResponse->assertOk();
    }

    public function test_oauth_client_post()
    {
        $user = User::firstOr(function () {
            return User::factory()->create();
        });
        $this->actingAs($user);
        $testResponse = $this->post('/oauth/clients', [
            'name' => 'test_' . now()->toString(),
            'redirect' => 'http://localhost:8000/callback',
        ], [
            'Accept' => 'application/json',
        ]);
        $testResponse->assertCreated();
    }
}
