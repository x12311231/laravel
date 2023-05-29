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


Route::get('/job/supervisorBatch', function () {
    $jobs = [];
    for ($i = 0; $i < 100; $i++) {
        $jobs[] = (new \App\Jobs\Supervisor1());
    }
    \Illuminate\Support\Facades\Bus::batch($jobs)->onQueue('supervisor')->dispatch();
    return 'ok';
})->name('job.su0');
Route::get('/job/supervisor', function () {
    \App\Jobs\Supervisor1::dispatch()->onQueue('supervisor');
    return 'ok';
})->name('job.su1');

Route::get('job/extra', function () {
    \App\Jobs\Extra::dispatch()->onQueue('extra');
    return 'ok';
})->name('job.ex1');
