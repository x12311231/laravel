<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::post('/sanctum/token', function (\App\Http\Requests\GetTokenRequest $request) {
//    $request->validate([
//        'email' => 'required|email',
//        'password' => 'required',
//        'device_name' => 'required',
//    ]);

    $request->validated();
    $user = User::where('email', $request->email)->first();

//    if (! $user || ! Hash::check($request->password, $user->password)) {
//        throw ValidationException::withMessages([
//            'email' => ['The provided credentials are incorrect.'],
//        ]);
//    }

    return $user->createToken($request->device_name)->plainTextToken;
});

Route::post('queue/pushMsg', [\App\Http\Controllers\QueueController::class, 'pushMsg']);
