<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public string $s;
    /**
     * Create a new job instance.
     */
    public function __construct(
//        $s
    )
    {
//        $this->s = $s;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Log::debug(__CLASS__ . ':' . __FUNCTION__ . '-');
//        Log::debug(__CLASS__ . ':' . __FUNCTION__ . '-' . $this->s);
    }
}
