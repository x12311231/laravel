<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class Retry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $connection = 'redis_retry9_connect';
    public int $tries = 3;

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
        Log::debug(__CLASS__ . ' --- ' . $this->title);
        for ($i = 0; $i < 130; $i++) {
            sleep(1);
            Log::channel('syslog')->debug($i . ' ' . $this->title);
        }
        Log::channel('errorlog')->debug($this->title . ' ' . now());
        Log::debug(__CLASS__ . ' -end- ' . $this->title);
        throw new \Exception("some exception");
    }
}
