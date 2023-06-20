<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_login()
    {
        $testResponse = $this->get('/login');
        $testResponse->assertOk();
    }

    public function test_login_post()
    {
//        $user = User::firstOr(function () {
//            return User::factory()
//                ->create(['password' => Hash::make('12345678')]);
//        });
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '123456789']);
        $testResponse->assertRedirect('/');
        $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '12345678']);
        $testResponse->assertRedirect('/home');
    }

    public function test_login_limiter()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '123456789']);
        $testResponse->assertRedirect('/');
        for ($i = 0; $i < 4; $i++) {
            $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '123456789'], ['Accept' => 'application/json']);
            $message = $testResponse->json('message');
            self::assertEquals('These credentials do not match our records.', $message);
            self::assertNotEquals('...', $message);
        }
        $testResponse = $this->post('/login', ['email' => $user->email, 'password' => '123456789'], ['Accept' => 'application/json']);

        $message = $testResponse->json('message');
        self::assertEquals('Too Many Attempts.', $message);
    }

    public function test_register()
    {
        $testResponse = $this->get(url('/register'));
        $testResponse->assertViewIs('auth.register');
        $testResponse1 = $this->post(url('register'), ['email' => 'test@qq.com', 'password' => '12345678', ]);
        $testResponse1->assertOk();
    }

    public function test_twoFactorLogin()
    {
        $this->actingAs(User::factory()->create());
        $testResponse = $this->get(route('two-factor.login'));
        $testResponse->assertOk();
    }
}
