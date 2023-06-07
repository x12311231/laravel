<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/redirect', function (Request $request) {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
                'client_id' => '4',
        //        'redirect_uri' => 'http://third-party-app.com/callback',
                'redirect_uri' => 'http://localhost:8000/callback',
                'response_type' => 'code',
                'scope' => '',
                'state' => $state,
                // 'prompt' => '', // "none", "consent", or "login"
    ]);
    $sourceHost = "http://localhost:8000";
    return redirect($sourceHost . '/oauth/authorize?'.$query);
 });

Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class,
        'Invalid state value.'
            );

    $sourceHost = "http://localhost:8000";
    $response = Http::asForm()->post($sourceHost . '/passport-app.test/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => '4',
        'client_secret' => 'ahi3EDNsXbWbGCWzMVacNf4FANvJ1b441hMpN75A',
        'redirect_uri' => 'http://localhost:8000/callback',
        //        'redirect_uri' => 'http://third-party-app.com/callback',
        'code' => $request->code,
            ]);

        return $response->json();
});
