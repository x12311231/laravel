<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::put('session/{value}', function (Request $request, string $value) {
    \Illuminate\Support\Facades\Session::put('testSession_' . $value, $value);
    return \Illuminate\Support\Facades\Session::get('testSession_' . $value);
})->name('api.session.put.1');

Route::get('session/{value}', function (Request $request, string $value) {
    return session('testSession_' . $value);
})->name('api.session.get.1');
