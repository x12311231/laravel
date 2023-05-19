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

Route::post('/batchJob', function (Request $request) {
    $jobs = [];
    $data = $request->validate(['limit' => ['required', 'integer', 'gte:1']]);
    $limit = $data['limit'];
    for ($i = 0; $i < 1000; $i++) {
        $jobs[] = (new \App\Jobs\BatchJob($i * $limit, ($limit + $i * $limit)));
    }
    return extracted($jobs);
})->name('batchJob.1');

/**
 * @param array $jobs
 * @return string
 * @throws Throwable
 */
function extracted(array $jobs): string
{
    $batch = \Illuminate\Support\Facades\Bus::batch($jobs)->onQueue('batch')
        ->then(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::channel('syslog')
                ->info('congratulation, batch job ' . $batch->id . ' is well done');
        })
        ->catch(function (\Illuminate\Bus\Batch $batch, Throwable $throwable) {
            \Illuminate\Support\Facades\Log::channel('syslog')
                ->error('batch job ' . $batch->id . ' with error occur,' . $throwable->getMessage());
        })
        ->finally(function (\Illuminate\Bus\Batch $batch) {
            \Illuminate\Support\Facades\Log::channel('syslog')
                ->critical('batch job ' . $batch->id . ' has been finished,' . json_encode([
                        'process' => $batch->progress() . '%',
                        'pending' => $batch->pendingJobs,
                        'has_failure' => $batch->hasFailures(),
                        'is_cancelled' => $batch->canceled(),
//                        'use_time' => \Carbon\Carbon::parse($batch->finishedAt)->diffInSeconds($batch->createdAt),
                        'use_time' => \Carbon\Carbon::now()->diffInSeconds($batch->createdAt),
                    ]));
        })
        ->dispatch();
    return $batch->id;
}

Route::post('/batchJobConcurrently', function (Request $request) {
    $jobs = [];
    $data = $request->validate(['limit' => ['required', 'integer', 'gte:1']]);
    $limit = $data['limit'];
    for ($i = 0; $i < 1000; $i++) {
        $jobs[] = (new \App\Jobs\BatchJobConcurrently($i * $limit, ($limit + $i * $limit)));
    }
    return extracted($jobs);
})->name('batchJob.2');

Route::post('/batchJobRateLimit', function (Request $request) {
    $jobs = [];
    $data = $request->validate(['limit' => ['required', 'integer', 'gte:1']]);
    $limit = $data['limit'];
    for ($i = 0; $i < 1000; $i++) {
        $jobs[] = (new \App\Jobs\BatchJobRateLimit($i * $limit, ($limit + $i * $limit)));
    }
    return extracted($jobs);
})->name('batchJob.3');

Route::post('/batchJobRateLimitViaMiddleware', function (Request $request) {
    $jobs = [];
    $data = $request->validate(['limit' => ['required', 'integer', 'gte:1']]);
    $limit = $data['limit'];
    for ($i = 0; $i < 1000; $i++) {
        $jobs[] = (new \App\Jobs\BatchJobRateLimitViaMiddleware($i * $limit, ($limit + $i * $limit)));
    }
    return extracted($jobs);
})->name('batchJob.4');
