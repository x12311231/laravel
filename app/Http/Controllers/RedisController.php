<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function connect()
    {
        $connection = Redis::connection();
//        dd($connection);
        return $connection->getName();
    }
}
