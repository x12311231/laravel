<?php

namespace App\Jobs\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(object): void  $next
     */
    public function handle(Object $job, Closure $next): void
    {
        Redis::throttle('jobRateLimit_' . $job::class)
            ->block(0)->allow(100)->every(5)
            ->then(function () use ($job, $next) {
                // Lock obtained...

                $next($job);
            }, function () use ($job) {
                // Could not obtain lock...

                $job->release(5);
            });
    }
}
