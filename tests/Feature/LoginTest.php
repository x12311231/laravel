<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
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
        $this->actingAs(User::where(['email' => '1434970057@qq.com'])->firstOr(function () {
            return User::factory(['email' => '1434970057@qq.com'])
                ->create();
        }));
        $response = $this->get('/ok');
        $session = $response->getCookie('laravel_session', false);
//        self::assertEquals($session->getValue(), 'eyJpdiI6InJvNDBlKzZQdGJnWVAvb2hIay84bmc9PSIsInZhbHVlIjoiWGxPWDBmemlQVGhTL3ZCdHdnWVhxSEp0WDlnVVhGM1pmNWx0cU5WYjFHMmdsV0ZSNCtuWkt4aC9oM203dzhnWkZCL2dITCtKcjFpdmh3K21LTTZCMjJ3SXBBaXdqTko3QVdTQlR3RFMzNFZjNnpFZjFsQ1pVZU84Q2tPSlRENksiLCJtYWMiOiJiODdlNjM0ZWRhZGMyNDE1YjEyYTZhMTQ1NzRhZjU5OGE1Y2Y1OWNlYzQ1MjkzNTczMjYyMmJlZGRkM2QxNzIyIiwidGFnIjoiIn0=');

        $response->assertOk();
        $response->assertContent('ok');
    }
}
