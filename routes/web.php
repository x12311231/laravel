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

Route::get('/search', function (\Illuminate\Http\Request $request) {
    return \App\Models\User::search($request->search)->get();
});

Route::get('/event', function () {
//    event(\App\Events\TestEvent::class);
    \App\Events\TestEvent::dispatch();
});

Route::get('/job', function () {
    \App\Jobs\TestJob::dispatch();
});

Route::get('/searchable/{user}', function (\App\Models\User $user) {
    $user->searchable();
    return $user;
});

Route::get('/noSearchable/{user}', function (\App\Models\User $user) {
    return $user;
});
