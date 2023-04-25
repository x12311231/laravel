<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class ConcurrencyRateLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        Log::debug('RateLimiter:' . __CLASS__);
        $url = $request->url();
        Redis::funnel($url)
            // 通过php artisan serve 启动服务的情况下只能串行通过单个请求，要测试可以通过nginx部署或octane package部署
            ->limit(2)
            ->block(1)
            ->then(function () {
                // 耗时任务应该放在这，这里的任务执行完成后释放锁，如果任务在函数外，提前释放了锁无法达到效果
                Log::debug('Oh my god');
                sleep(5);
            }, function () {
                Log::debug('Too Many Request');
                abort(429, 'Too Many Request');
            });
        return $next($request);
    }
}
