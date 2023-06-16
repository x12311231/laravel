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

Route::post('/token', function (Request $request) {
//    return 'ok';
    $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => ['required']
    ])->validated();
    $user = \App\Models\User::where(['email' => $validated['email']])
        ->firstOrFail();
    \Illuminate\Support\Facades\Auth::setUser($user);
    if (!\Illuminate\Support\Facades\Auth::validate($validated)) {
        throw new \Illuminate\Auth\AuthenticationException();
    }
    return $user->createToken('user_' . $user->email);
})->name('token');
