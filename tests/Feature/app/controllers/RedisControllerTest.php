<?php

namespace Tests\Feature\app\controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_conn()
    {
        $response = $this->get(route('redis.conn'));
        $response->assertOk();
    }

    public function test_lua_zadd1()
    {
        $response = $this->get(route('redis.luaZadd'));
        $response->assertOk();
    }
    public function test_lua_zadd()
    {
        $value = Redis::eval(<<<'LUA'
        redis.call('zadd', KEYS[1], 98, 'maghen', 99, 'angle')
        print(ARGV[1])
        print(ARGV[1] + 1)
        return redis.call('zrange', KEYS[1], 0, 100)
LUA, 1, 'score', 11);

        self::assertEquals(2, count($value));
        self::assertTrue(true);
    }

    public function test_lua0()
    {
        for ($i = 0; $i < 10; $i++) {
            Redis::eval(<<<'LUA'
        print(ARGV[1])
LUA, 1, 'test', $i);
        }
        self::assertTrue(true);
    }

    public function test_lua1()
    {
        $key1 = 'first-counter';
        Redis::del($key1);
        $key2 = 'second-counter';
        Redis::del($key2);
        $i1 = 3;
        Redis::set($key1, $i1);
        $i3 = 10;
        Redis::set($key2, $i3);
        $i2 = 30;
        for ($i = 0; $i < $i2; $i++) {
            $response = $this->get(route('redis.lua1'));
            $response->assertOk();
            $response->assertContent((string)($i + 1 + $i1));
        }
        self::assertEquals($i1 + $i2, Redis::get($key1));
        self::assertEquals($i1 + $i2 - 5 + $i3, Redis::get($key2));
    }

    public function test_lua2()
    {
        $key1 = 'first-counter';
        Redis::del($key1);
        $key2 = 'second-counter';
        Redis::del($key2);
        $i1 = 3;
        Redis::set($key1, $i1);
        $i3 = 10;
        Redis::set($key2, $i3);
        $i2 = 30;
        for ($i = 0; $i < $i2; $i++) {
            $response = $this->get(route('redis.lua2', ['argv' => $i]));
            $response->assertOk();
            $response->assertContent((string)($i + 1 + $i1));
        }
        self::assertEquals($i1 + $i2, Redis::get($key1));
        self::assertEquals($i1 + $i2 - 5 + $i3, Redis::get($key2));
    }
}
