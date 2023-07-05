<?php

use \Illuminate\Support\Facades\Route;

Route::get('/liveWire', function () {
    return view('liveWire');
});

Route::get('/users', function () {
    $users = \App\Models\User::paginate(10);
    return view('user.index', ['users' => $users->toArray()]);
});


Route::get('/user', \App\Http\Livewire\User::class);
Route::get('/user/article/{article}', \App\Http\Livewire\User::class)->name('u.a');
Route::get('/user1', \App\Http\Livewire\User1::class);

Route::get('/post/{post}', \App\Http\Livewire\Post\Show::class);
Route::get('/post/update/{post}', \App\Http\Livewire\Post\Update::class);

Route::get('/post', \App\Http\Livewire\Post\Index::class);
Route::get('/post1', \App\Http\Livewire\Post\Index1::class);

Route::get('/posts/form', \App\Http\Livewire\PostForm::class);

Route::get('/posts/edit/{post}', \App\Http\Livewire\PostForm::class);
