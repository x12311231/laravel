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
})->name('api.user.1');

Route::middleware(['auth:api', 'scope:get-user'])->get('/user2', function (Request $request) {
    return $request->user();
})->name('api.user.2');

Route::middleware(['auth:api', 'scope:get-goods'])->get('/goods', function() {
    return 'ok';
})->name('api.goods');

Route::get('/coffee/{coffee}', function (\App\Models\Coffee $coffee) {
    return $coffee;
})->middleware('client')->name('api.coffee');

