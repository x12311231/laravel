<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function getConnection()
    {
        $redis = Redis::connection();
        dd($redis);
    }

    public function lua0()
    {
        for ($i = 0; $i < 10; $i++) {
            Redis::eval(<<<'LUA'
        print(ARGV[1])
LUA, 1, 'test', $i);
        }
    }

    public function lua1()
    {
        $value = Redis::eval(<<<'LUA'
    local counter = redis.call("incr", KEYS[1])

    if counter > 5 then
        redis.call("incr", KEYS[2])
    end

    return counter
LUA, 2, 'first-counter', 'second-counter');
        return $value;
    }

    public function lua2($argv)
    {
        $value = Redis::eval(<<<'LUA'
    local counter = redis.call("incr", KEYS[1])

    if counter > 5 then
        redis.call("incr", KEYS[2])
    end

    redis.call("set", "str_" .. ARGV[1], ARGV[1])

    return counter
LUA, 2, 'first-counter', 'second-counter', $argv);
        return $value;
    }

    public function lua_zadd()
    {
        $value = Redis::eval(<<<'LUA'
        redis.call('zadd', KEYS[1], ARGV[1], 'testtttzadd')
        return redis.call('zrange', KEYS[1], 0, 100)
LUA, 1, 'zaddKey', 11);
        return $value;
    }

}
