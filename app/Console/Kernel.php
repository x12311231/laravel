<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Process\Process;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $size = Queue::size('extra');
            if ($size > 1) {
                Log::debug('queue extra size > 1:' . $size);
                Process::fromShellCommandline('sudo supervisorctl start laravel-supervisor-extra:*')
                ->run();
            } else {
                Log::debug('queue extra size < 1');
                Process::fromShellCommandline('sudo supervisorctl stop laravel-supervisor-extra:*')->run();
            }
        })->everyMinute();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->call(function () {
            if (rand(0, 100) > 50) {
                for ($i = 0; $i < rand(1, 20); $i++) {
                    Process::fromShellCommandline('curl http://localhost:8000/api/job/extra')
                        ->run();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
