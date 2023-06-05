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

Route::get('/job/{rollback}', function (string $rollback) {
    \Illuminate\Support\Facades\DB::transaction(function () use ($rollback) {
        \App\Models\User::factory()->create();
        if ('true' == $rollback) {
            \Illuminate\Support\Facades\Log::channel('syslog')
                ->debug('job exception happen');
            throw new \Exception("some err");
        }
        // 开启afterCommit后，应把队列任务置于最后（异常后）
        \App\Jobs\Test::dispatch()->onQueue('default')->afterCommit();
    });
})->name('job.1');

Route::resource('post', App\Http\Controllers\PostController::class);
