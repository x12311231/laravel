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
        $testResponse->assertTooManyRequests();
//        $message = $testResponse->json('message');
//        self::assertEquals('Too Many Attempts.', $message);
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

    public function test_confirmPassword()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $this->actingAs($user);
        $testResponse = $this->get(url('/user/confirm-password'), ['Accept' => 'application/json']);
        $testResponse->assertOk();
    }

    public function test_confirmationPassword()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $this->actingAs($user);
        $testResponse = $this->get(route('password.confirmation'));
        $testResponse->assertOk();
        $json = $testResponse->json('confirmed');
        self::assertFalse($json);
    }

    public function test_confirmPasswordPost()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $this->actingAs($user);

        $testResponse = $this->post(url('/user/confirm-password'),['password' => '12345678'], ['Accept' => 'application/json']);
        $testResponse->assertCreated();
        $testResponse->assertSessionMissing('asdjfksdfj');
        $testResponse->assertSessionHas('auth.password_confirmed_at');
        $testResponse = $this->get(route('password.confirmation'));
        $testResponse->assertOk();
        $json = $testResponse->json('confirmed');
        self::assertTrue($json);
    }


    public function test_twoFactorRecoveryCodes()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $this->actingAs($user);

        $testResponse = $this->post(url('/user/confirm-password'),['password' => '12345678'], ['Accept' => 'application/json']);
        $testResponse->assertCreated();
        $testResponse->assertSessionMissing('asdjfksdfj');
        $testResponse->assertSessionHas('auth.password_confirmed_at');

        $testResponse1 = $this->post(route('two-factor.enable'), [], ['Referer' => url('/home')]);
        $testResponse1->assertRedirect(url('/home'));
        $testResponse1 = $this->post(url('user/two-factor-recovery-codes'), [], ['Referer' => route('two-factor.recovery-codes')]);
        $testResponse1->assertRedirect(route('two-factor.recovery-codes'));
        $testResponse = $this->get(route('two-factor.recovery-codes'), ['Accept' => 'application/json']);
        $testResponse->assertOk();
//        $testResponse->assertJ
    }


    public function test_twoFactorChallege()
    {
        $testResponse = $this->get(route('two-factor.login'));
//        $testResponse->assertRedirect();
        $testResponse->assertRedirect('/login');
        $this->actingAs(User::firstOr(function () {
            return User::factory()->create();
        }));
        $testResponse = $this->get(route('two-factor.login'));
//        $testResponse->assertRedirect();
        $testResponse->assertRedirect('/home');
    }

    public function test_twoFactorChallegePost()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $this->actingAs($user);

        $testResponse = $this->post(url('/user/confirm-password'),['password' => '12345678'], ['Accept' => 'application/json']);
        $testResponse->assertCreated();
        $testResponse->assertSessionMissing('asdjfksdfj');
        $testResponse->assertSessionHas('auth.password_confirmed_at');

        $testResponse1 = $this->post(route('two-factor.enable'), [], ['Referer' => url('/home')]);
        $testResponse1->assertRedirect(url('/home'));
        $testResponse1 = $this->post(url('user/two-factor-recovery-codes'), [], ['Referer' => route('two-factor.recovery-codes')]);
        $testResponse1->assertRedirect(route('two-factor.recovery-codes'));
        $testResponse = $this->get(route('two-factor.recovery-codes'), ['Accept' => 'application/json']);
        $testResponse->assertOk();
        $content = $testResponse->content();
        $testResponse = $this->post(route('two-factor.login'), ['recovery_code' => 'fake test']);
        $testResponse->assertOk();
        $testResponse = $this->post(route('two-factor.login'), ['recovery_code' => $content[0]]);
        $testResponse->assertRedirect(url('/home'));
    }
    public function test_twoFactorQrCode()
    {
        $user = User::factory()->create(['password' => Hash::make('12345678')]);
        $this->actingAs($user);

        $testResponse = $this->post(url('/user/confirm-password'),['password' => '12345678'], ['Accept' => 'application/json']);
        $testResponse->assertCreated();
        $testResponse->assertSessionMissing('asdjfksdfj');
        $testResponse->assertSessionHas('auth.password_confirmed_at');

        $testResponse1 = $this->post(route('two-factor.enable'), [], ['Referer' => url('/home')]);
        $testResponse1->assertRedirect(url('/home'));

        $testResponse = $this->get(route('two-factor.qr-code'), ['Accept' => 'application/json']);
        $testResponse->assertOk();
    }
}
