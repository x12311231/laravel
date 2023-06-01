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

Route::get('/user/{user}', function (\App\Models\User $user) {
    return $user;
});

Route::get('/users/{user}', function (string $user) {
    return \App\Models\User::find($user);
});

Route::get('/postt/{post}', function (\App\Models\Post $post) {
    dd(is_array($post->tags));
    return $post;
});

Route::get('/post1/{post}', function (\App\Models\Post $post) {
    return $post;
});

Route::resource('post', App\Http\Controllers\PostController::class)->only('index', 'store');





