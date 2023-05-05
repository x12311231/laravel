<?php

use Illuminate\Http\Request;
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

Route::get('session/put/{value}', function (Request $request, string $value) {
    \Illuminate\Support\Facades\Session::put('testWebSession_' . $value, $value);
    return \Illuminate\Support\Facades\Session::get('testWebSession_' . $value);
})->name('web.session.put.1');

Route::get('session/get/{value}', function (Request $request, string $value) {
    return session('testWebSession_' . $value);
})->name('web.session.get.1');
