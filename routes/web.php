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

Route::get('/test', function () {
    return 'test';
});

Route::get('/test/hello', [\App\Http\Controllers\TestController::class, 'index']);

Route::controller(\App\Http\Controllers\PostController::class)->group(function() {
    Route::get('/posts/{id}', 'show');
    Route::get('/posts', 'index');
});
