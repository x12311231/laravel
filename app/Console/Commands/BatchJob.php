<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class BatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:find
                            {batchId : batch job id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'search the batch job state with batch id';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $batch = Bus::findBatch($this->argument('batchId'));
        if (!$batch) {
            return $this->error('batch job is not exists');
        }
        $this->info(json_encode([
            'process' => $batch->progress() . '%',
            'pending' => $batch->pendingJobs,
            'has_failure' => $batch->hasFailures(),
            'is_cancelled' => $batch->canceled(),
        ]));
    }
}
