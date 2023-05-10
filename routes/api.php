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

Route::get('/job/failed', function () {
    \App\Jobs\FailedJob::dispatch()->delay(now()->addSeconds(5))->onQueue('job');
    return 'ok';
})->name('job.failed');
Route::get('/job/exception', function () {
    \App\Jobs\ExceptionJob::dispatch()->delay(now()->addSeconds(5))->onQueue('job');
    return 'ok';
})->name('job.exception');
Route::get('/job/release', function () {
    \App\Jobs\ReleaseJob::dispatch()->delay(now()->addSeconds(0))->onQueue('job');
    \App\Jobs\ReleaseJob::dispatch()->delay(now()->addSeconds(0))->onQueue('job');
    return 'ok';
})->name('job.release');
