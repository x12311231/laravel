<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/csrfToken', function (Request $request) {
    $token = $request->session()->token();

//    $token = csrf_token();
    return 'X-CSRF-TOKEN: ' . $token;
    // ...
})->name('csrf');

Route::get('/tailcss', function () {
    return view('tailcss');
});

Route::get('/home', function () {
    return view('home');
})->name('home');
