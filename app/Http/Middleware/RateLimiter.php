<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\InteractsWithTime;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter as Limiter;
use Termwind\Components\Li;

class RateLimiter
{
    use InteractsWithTime;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//
        $maxAttempts = 6;
        $res = Limiter::attempt($request->url(), $maxAttempts, function () {

        }, 30);
        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => Limiter::remaining($request->url(), $maxAttempts),
        ];
        if (!$res) {
            $availableIn = Limiter::availableIn($request->url());
            $headers['Retry-After'] = $availableIn;
            $headers['X-RateLimit-Reset'] = $this->availableAt($availableIn);

            abort(429, "Too Many Request", $headers);
        }
        $response = $next($request);
        $response->headers->add($headers);
        return $response;
    }
}
