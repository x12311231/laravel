<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailTest extends TestCase
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

    public function test_send()
    {
        $this->actingAs(User::factory([
            'name' => '143',
            'email' => '1434970057@qq.com',
        ])->create());
        $response = $this->post(route('api.mail.send'));
        $response->assertStatus(200);
        $response->assertContent('ok');
    }

    public function test_notice()
    {
        $this->actingAs(User::factory([
            'name' => '123456',
            'email' => '1434970057@qq.com',
        ])->create());
        $response = $this->post(route('api.n.1'));
        $response->assertOk();
        $response->assertContent('ok');
    }
}
