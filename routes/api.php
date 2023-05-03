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

Route::post('mail/send', function (Request $request) {
    $msg = \Illuminate\Support\Facades\Mail::to($request->user())->send(new \App\Mail\TestMail());
    return 'ok';
})->name('api.mail.send');

Route::post('job/dispatch', function (Request $request) {
//    \App\Jobs\TestJob::dispatch();
    dispatch(new \App\Jobs\TestJob('a'))->onQueue('default');
    return 'ok job';
})->name('api.job.1');

Route::post('job/a1', [\App\Http\Controllers\JobController::class, 'test'])->name('api.job.2');
