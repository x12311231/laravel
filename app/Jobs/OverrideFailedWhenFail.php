<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OverrideFailedWhenFail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $title
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('test OverrideFailedWhenFail:' . $this->title);
        $this->fail("test OverrideFailedWhenFail");
    }

    /**
     * @param $exception
     * @return void
     * 重写fail方法
     */
    public function fail($exception = null)
    {
        Log::debug('log exception:' . json_encode($exception));

    }
}
