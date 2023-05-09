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

Route::get('/ok', function () {
    return 'ok';
})->middleware('auth');

Route::get('/auth/login/{user}', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/auth/welcome', [\App\Http\Controllers\AuthController::class, 'welcome'])->middleware('auth')->name('auth.welcome');

Route::post('/order/store', [\App\Http\Controllers\OrderController::class, 'store'])->middleware('auth')->name('order.store');
Route::put('/order/{order}/pay', [\App\Http\Controllers\OrderController::class, 'pay'])->middleware('auth')->name('order.pay');
