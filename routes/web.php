<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redis/connect', [\App\Http\Controllers\RedisController::class, 'connect']);

Route::get('/site_visits', function () {
    return '网站全局访问量：' . \Illuminate\Support\Facades\Redis::get('site_total_visits');
});

Route::get('article/popular', [\App\Http\Controllers\ArticleController::class, 'popular'])->name('article.popular');
Route::resource('article', App\Http\Controllers\ArticleController::class)->only('index', 'show', 'store');

