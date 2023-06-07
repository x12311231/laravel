<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_api1()
    {
        $user = User::firstOr(function () {
            return User::factory()->create();
        });
        $this->actingAs($user);
        $response = $this->get(route('api.user.1'));
        $response->assertOk();
    }

    public function test_api2()
    {
        $user = User::firstOr(function () {
            return User::factory()->create();
        });
        $this->actingAs($user);
        $response = $this->get(route('api.user.2'), ['Accept' => 'application/json']);
//        $response = $this->get(route('api.user.2'));
        $response->assertOk();
    }
}
