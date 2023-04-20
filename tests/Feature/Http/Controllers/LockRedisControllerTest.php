<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LockRedisControllerTest extends TestCase
{
    const TIMES = 10000;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_noLockInTwoProcess()
    {
        $response = $this->get('/lockRedis/noLockInTwoProcess');
        $response->assertOk();
        self::assertEquals(true, (int)($response->content()) < self::TIMES * 2);
    }

    public function test_lockInTwoProcess()
    {
        $response = $this->get('/lockRedis/lockInTwoProcess');
        $response->assertOk();
        self::assertEquals(true, (int)($response->content()) < self::TIMES * 2);
    }


    public function test_lockInTwoProcess1()
    {
        $response = $this->get('/lockRedis/lockInTwoProcess1');
        $response->assertOk();
        $response->assertContent((string)(self::TIMES * 2));
    }
    public function test_lock()
    {
        $response = $this->get('/lockRedis/lock');
        $response->assertOk();
        $response->assertContent((string)self::TIMES);
    }

    public function test_noLock()
    {
        $response = $this->get('/lockRedis/noLock');
        $response->assertOk();
        $response->assertContent((string)self::TIMES);
    }
}
