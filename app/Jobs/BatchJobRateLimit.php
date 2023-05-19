<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\assertTrue;

class BatchJobRateLimit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;

    public int $tries = 0;

    public function retryUntil()
    {
        return now()->addMinutes(60);
    }

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $start,
        public readonly int $end,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Redis::throttle(__CLASS__ . '_rateLimit')->block(0)->allow(100)->every(5)->then(function () {
            info('Lock obtained...');

            $this->doHandle();
            // Handle job...
        }, function () {
            // Could not obtain lock...

            return $this->release(5);
        });
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function doHandle(): void
    {
        $sum = 0;
        for ($i = $this->start; $i < $this->end; $i++) {
            if (($r = random_int(0, 1000)) > 999) {
                Log::channel('syslog')->debug('unluckily:' . $r);
                $this->fail("unluckily:" . $r);
            }
            $sum += $i;
        }
        $res = Redis::set('sum_' . $this->start . '_' . $this->end, $sum);
        assertTrue($res); //
    }
}
