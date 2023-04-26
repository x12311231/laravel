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

Route::get('/post/{id}', [\App\Http\Controllers\PostController::class, 'show'])->middleware([\App\Http\Middleware\PostView::class]);
Route::get('/post1/{id}', [\App\Http\Controllers\PostController::class, 'show'])->middleware([\App\Http\Middleware\PostView1::class]);
