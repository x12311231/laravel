<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;

class QueueController extends Controller
{
    public function pushMsg(Request $request)
    {
        $data = $request->validate(['msg' => 'required']);
//        Event::dispatch(new TestJob($data['msg']));
        TestJob::dispatch($data['msg']);
        return 'ok';
    }
}
