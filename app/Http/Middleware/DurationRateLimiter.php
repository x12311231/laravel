<?php

namespace App\Http\Middleware;

use Closure;
use http\Encoding\Stream\Debrotli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class DurationRateLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Redis::throttle($request->url())
            ->allow(100)->every(10)
            ->then(function () {}, function () {
                abort(429, "Too Many Request");
            });
        return $next($request);
    }
}
