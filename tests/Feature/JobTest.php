<?php

namespace Tests\Feature;

use App\Jobs\ExceptionJob;
use App\Jobs\FailedJob;
use App\Jobs\ReleaseJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JobTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_job_failed()
    {
        Queue::fake([
            FailedJob::class,
        ]);
        $response = $this->get(route('job.failed'));
        $response->assertOk();
        Queue::assertPushedOn('job', FailedJob::class);
        Queue::assertPushed(FailedJob::class, 1);

    }

    public function test_job_exception()
    {

        Queue::fake([
            ExceptionJob::class,
        ]);
        $response = $this->get(route('job.exception'));
        $response->assertOk();
        Queue::assertPushedOn('job', ExceptionJob::class);
        Queue::assertPushed(ExceptionJob::class, 1);
    }

    public function test_job_release()
    {

        Queue::fake([
            ReleaseJob::class,
        ]);
        $response = $this->get(route('job.release'));
        $response->assertOk();
        Queue::assertPushedOn('job', ReleaseJob::class);
        Queue::assertPushed(ReleaseJob::class, 2);
    }
}
