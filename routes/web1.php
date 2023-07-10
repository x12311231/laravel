<?php

use \Illuminate\Support\Facades\Route;

Route::get('/vue', function () {
    return layout('vue');
});

Route::post('/users', function (\App\Http\Requests\StoreUserRequest $request) {

})->middleware([\Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class]);
