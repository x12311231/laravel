<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Illuminate\Queue\Jobs\Job;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_timee()
    {

        $rand = rand(0, 60 * 60);
        $time = Carbon::createFromTime()->addMinutes($rand);
        $time1 = Carbon::createFromTime(0, 0, 0)->addMinutes($rand);
        self::assertEquals($time1, $time);
        self::assertEquals(0, $time->diffInMinutes($time1));
    }
}
