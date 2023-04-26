<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class PostView1
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
        Redis::pfAdd('post_daily_uv1_' . \Illuminate\Support\Carbon::now()->toDateString(), ['user:' . $request->input('userId') . '_post:' . $this->route->parameter('id')]);
        return $next($request);
    }
}
