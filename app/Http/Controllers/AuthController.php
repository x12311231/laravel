<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(User $user)
    {
        Auth::login($user);
        return redirect(route('auth.welcome'));
    }

    public function welcome(Request $request) {
        return 'welcome ' . $request->user()->name;
    }
}
