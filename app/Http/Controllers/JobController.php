<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    //
    public function test()
    {

        \App\Jobs\TestJob::dispatch('b')->onQueue('default');
        dispatch(new \App\Jobs\TestJob('a'))->onQueue('default');
    }
}
