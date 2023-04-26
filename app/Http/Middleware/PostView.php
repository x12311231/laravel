<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PostView
{
    public function __construct(
        public Route $route,
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        Log::debug('route:' . json_encode($this->route));
//        Log::debug('post:' . $this->route->parameter('id'));
        /* var Redis \Redis  */
        Redis::sadd('post_daily_uv_' . \Carbon\Carbon::now()->toDateString(), 'user:' . $request->input('userId') . '_post:' . $this->route->parameter('id'));
        return $next($request);
    }
}
