<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(): string
    {
        $a = 1;
        $c = $a + 2;
        User::all();
        return 'test hello';
    }
}
