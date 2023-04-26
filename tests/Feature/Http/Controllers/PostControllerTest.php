<?php

namespace Tests\Feature\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_show10000()
    {
        $key = 'post_daily_uv_' . Carbon::now()->toDateString();
        Redis::del($key);
        for ($i = 0; $i < 10000; $i++) {
            $response = $this->get('/post/1?userId=' . $i);
            $response->assertOk();
        }
        $count = Redis::scard($key);
        $this->assertEquals(10000, $count);
    }

    public function test_show10000_in_guzzle()
    {
        $key = 'post_daily_uv_' . Carbon::now()->toDateString();
        Redis::del($key);
        $requests = function ($total) {
            for ($i = 0; $i < $total; $i++) {
                $uri = 'http://localhost:8000/post/1?userId=' . $i;
                yield new Request('GET', $uri);
            }
        };
        $pool = new Pool(new Client(), $requests(10000), [
            'concurrency' => 1000,
            'fulfilled' => function ($response, $index) {
                // this is delivered each successful response
                self::assertEquals(200, $response->getStatusCode());
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
                Log::error('[' . __FUNCTION__ . ']' . "reason:{$reason} index:{$index}");
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();
        $count = Redis::scard($key);
        $this->assertEquals(10000, $count);
    }

    public function test_show10000_pf()
    {
        $key = 'post_daily_uv1_' . Carbon::now()->toDateString();
        Redis::del($key);
        for ($i = 0; $i < 10000; $i++) {
            $response = $this->get('/post1/1?userId=' . $i);
            $response->assertOk();
        }
        $count = Redis::pfcount($key);
        $this->assertTrue(abs(($count - 10000) / 10000) <= 0.81);
    }

    public function test_show10000_in_guzzle_pf()
    {
        $key = 'post_daily_uv1_' . Carbon::now()->toDateString();
        Redis::del($key);
        $requests = function ($total) {
            for ($i = 0; $i < $total; $i++) {
                $uri = 'http://localhost:8000/post1/1?userId=' . $i;
                yield new Request('GET', $uri);
            }
        };
        $pool = new Pool(new Client(), $requests(10000), [
            'concurrency' => 1000,
            'fulfilled' => function ($response, $index) {
                // this is delivered each successful response
                self::assertEquals(200, $response->getStatusCode());
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
                Log::error('[' . __FUNCTION__ . ']' . "reason:{$reason} index:{$index}");
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();
        $count = Redis::pfcount($key);
        $this->assertTrue(abs(($count - 10000) / 10000) <= 0.81);
    }

    public function test_million_key()
    {
        $key = 'testttttttt_pf';
        Redis::del($key);
        Redis::pipeline(function ($pipe) use ($key) {
            for ($i = 0; $i < 1000000; $i++) {
                $pipe->pfAdd($key, ['test_' . $i]);
            }
        });
        $count = Redis::pfcount($key);
        $abs = abs(($count - 1000000) / 1000000);
        echo $abs;
        $this->assertTrue($abs <= 0.81);
    }
}
