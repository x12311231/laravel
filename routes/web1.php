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

Route::middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])->group(function () {
    Route::get('/home', function (Request $request) {
        return view('home', ['user' => $request->user()]);
    })->name('home');
    Route::get('fortify/safety', function () {
        return view('auth.safety');
    })->name('auth.two-factor-authentication');
//    Route::resource('profile', App\Http\Controllers\ProfileController::class);
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/challenge', function (Request $request) {
    return view('challenge.home', ['request' => $request]);
});
