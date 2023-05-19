<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use function PHPUnit\Framework\assertTrue;

class BatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;

//    public $queue = 'batch';

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
        $sum = 0;
        for ($i = $this->start; $i < $this->end; $i++) {
            if (($r = random_int(0, 1000)) > 999) {
                Log::channel('syslog')->debug('unluckily:' . $r);
                $this->fail("unluckily:" . $r);
            }
            $sum += $i;
        }
        $res = Redis::set('sum_' . $this->start . '_' . $this->end, $sum);
        assertTrue($res);
    }
}
