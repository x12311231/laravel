<?php

use Illuminate\Support\Facades\Route;

Route::get('/lock/noLockInTwoProcess', [\App\Http\Controllers\LockController::class, 'noLockInTwoProcess']);

Route::get('/lock/lockInTwoProcess', [\App\Http\Controllers\LockController::class, 'lockInTwoProcess']);
Route::get('/lock/lockInTwoProcess1', [\App\Http\Controllers\LockController::class, 'lockInTwoProcess1']);

Route::get('/lock/lock', [\App\Http\Controllers\LockController::class, 'lock']);
Route::get('/lock/noLock', [\App\Http\Controllers\LockController::class, 'noLock']);

Route::get('/lockRedis/noLockInTwoProcess', [\App\Http\Controllers\LockRedisController::class, 'noLockInTwoProcess']);

Route::get('/lockRedis/lockInTwoProcess', [\App\Http\Controllers\LockRedisController::class, 'lockInTwoProcess']);
Route::get('/lockRedis/lockInTwoProcess1', [\App\Http\Controllers\LockRedisController::class, 'lockInTwoProcess1']);

Route::get('/lockRedis/lock', [\App\Http\Controllers\LockRedisController::class, 'lock']);
Route::get('/lockRedis/noLock', [\App\Http\Controllers\LockRedisController::class, 'noLock']);
