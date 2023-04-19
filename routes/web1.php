<?php

use Illuminate\Support\Facades\Route;

Route::get('/redis/connect', [\App\Http\Controllers\RedisController::class, 'connect']);

Route::get('/site_visits', function () {
    return '网站全局访问量：' . \Illuminate\Support\Facades\Redis::get('site_total_visits');
});
Route::get('article/popular', [\App\Http\Controllers\ArticleController::class, 'popular'])->name('article.popular');
Route::resource('article', App\Http\Controllers\ArticleController::class)->only('index', 'show', 'store');

Route::get('/broadcast', function () {
    return view('broadcast');
});

Route::get('/room/{id}/join', function ($id) {
    broadcast(new \App\Events\UserJoinRoom(request()->user(), $id))->toOthers();
    return ['joinRoom' => ['user' => request()->user(), 'roomID' => $id]];
});
