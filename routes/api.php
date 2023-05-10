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

Route::get('/job/failed/{title}', function (string $title) {
    \App\Jobs\FailedJob::dispatch($title)->delay(now()->addSeconds(5))->onQueue('job');
    return 'ok';
})->name('job.failed');
Route::get('/job/exception/{title}', function (string $title) {
    \App\Jobs\ExceptionJob::dispatch($title)->delay(now()->addSeconds(5))->onQueue('job');
    return 'ok';
})->name('job.exception');
Route::get('/job/release/{title}', function (string $title) {
    \App\Jobs\ReleaseJob::dispatch($title)->delay(now()->addSeconds(0))->onQueue('job');
//    \App\Jobs\ReleaseJob::dispatch()->delay(now()->addSeconds(0))->onQueue('job');
    return 'ok';
})->name('job.release');

Route::get('/job/overrideFailedWhenExceedTries/{title}', function (string $title) {
    \App\Jobs\OverrideFailedWhenExceedTries::dispatch($title)->delay(now()->addSeconds(0))->onQueue('job');
    return 'ok';
})->name('job.overrideFailedWhenExceedTries');
Route::get('/job/overrideFailedWhenException/{title}', function (string $title) {
    \App\Jobs\OverrideFailedWhenException::dispatch($title)->delay(now()->addSeconds(0))->onQueue('job');
    return 'ok';
})->name('job.overrideFailedWhenException');
Route::get('/job/overrideFailedWhenFail/{title}', function (string $title) {
    \App\Jobs\OverrideFailedWhenFail::dispatch($title)->delay(now()->addSeconds(0))->onQueue('job');
    return 'ok';
})->name('job.overrideFailedWhenFail');
Route::get('/job/retryUntil/{title}', function (string $title) {
    \App\Jobs\RetryUntil::dispatch($title)->delay(now()->addSeconds(0))->onQueue('job');
    return 'ok';
})->name('job.retryUntil');

