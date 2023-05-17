<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class Retry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $connection = 'redis_retry9_connect';
    public int $tries = 3;

    public int $timeout = 19;

    public $maxExceptions = 3;

    public $failOnTimeout = true;

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
        try {
            Log::debug(__CLASS__ . ' --- ' . $this->title);
            for ($i = 0; $i < 190; $i++) {
                sleep(1);
                Log::channel('syslog')->debug($i . ' ' . $this->title);
            }
            Log::channel('errorlog')->debug($this->title . ' ' . now());
            Log::debug(__CLASS__ . ' -end- ' . $this->title);
        } catch (\Exception $e) {
            Log::channel('syslog')->debug('some exception ' . $e->getMessage());
//            throw new $e;
        }
        throw new \Exception("some exception");
    }
    /**
     * Determine if the job should fail when it timeouts.
     *
     * @return bool
     */
//    public function shouldFailOnTimeout()
//    {
////        return $this->payload()['failOnTimeout'] ?? false;
//        return true;
//    }

}
