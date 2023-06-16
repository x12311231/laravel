<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FortifyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_post()
    {
        $user = User::firstOr(function () {
            return User::factory()
                ->create(['password' => Hash::make('12345678')]);
        });
        $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '123456789']);
        $testResponse->assertRedirect('/');
        $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '12345678']);
        $testResponse->assertRedirect('/home');
    }
}
