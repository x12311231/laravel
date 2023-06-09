<?php

namespace Tests\Feature;

use App\Models\Coffee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
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
//        $user = User::firstOr(function () {
//            return User::factory()->create();
//        });
        $user = User::factory()->create([
            'name' => 'oauth' . rand(0, 100),
            'password' => Hash::make('12345678'),
        ]);
        $this->actingAs($user);
        $testResponse = $this->post('/oauth/clients', [
            'name' => 'test_' . now()->toString(),
            'redirect' => 'http://localhost:8000/callback',
        ], [
            'Accept' => 'application/json',
        ]);
        $testResponse->assertCreated();
    }

    public function test_oauth2_client_unauthorized()
    {
        $coffee = Coffee::firstOr(function () {
            return Coffee::factory()->create();
        });
        $testResponse = $this->get(route('api.coffee', ['coffee' => $coffee]), ['Accept' => 'application/json']);
        $testResponse->assertUnauthorized();
    }

    public function test_post_oauth2_personal_access_token()
    {
        $user = User::where(['email' => 'test1@qq.com'])
            ->firstOr(function () {
                return User::factory()->create(['email' => 'test1@qq.com', 'password' => Hash::make('12345678')]);
            });
        $this->actingAs($user, 'web');
        $data = [
            'name' => 'personal access token ' . now()->timestamp,
            'scopes' => ['get-user', 'get-goods']
        ];
        $testResponse = $this->post('/oauth/personal-access-tokens', $data, ['Accept' => 'application/json']);
        $testResponse->assertOk();
        $token = $testResponse->json('accessToken');
        $testResponse1 = $this->get(route('api.user.1'), ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json']);
//        $testResponse1->assertUnauthorized();
        $testResponse1 = $this->get(route('api.user.2'), ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json']);
        $testResponse1->assertOk();
        $testResponse3 = $this->get(route('api.goods'), ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json']);
        $testResponse3->assertOk();
    }

    public function test_post_oauth2_personal_access_token1()
    {
        $user = User::where(['email' => 'test1@qq.com'])
            ->firstOr(function () {
                return User::factory()->create(['email' => 'test1@qq.com', 'password' => Hash::make('12345678')]);
            });
        $this->actingAs($user, 'web');
        $data = [
            'name' => 'personal access token ' . now()->timestamp,
            'scopes' => ['get-user']
        ];
        $testResponse = $this->post('/oauth/personal-access-tokens', $data, ['Accept' => 'application/json']);
        $testResponse->assertOk();
        $token = $testResponse->json('accessToken');
        $testResponse1 = $this->get(route('api.user.1'), ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json']);
//        $testResponse1->assertUnauthorized();
        $testResponse1 = $this->get(route('api.user.2'), ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json']);
        $testResponse1->assertOk();
        $testResponse3 = $this->get(route('api.goods'), ['Authorization' => 'Bearer ' . $token, 'Accept' => 'application/json']);
        $testResponse3->assertForbidden();
    }
}
