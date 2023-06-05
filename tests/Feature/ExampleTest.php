<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ExampleTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_create()
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount(User::class, 1);
        $res = User::destroy($user->id);
        self::assertTrue($res == $user->id);
    }

    public function test_job_rollback()
    {
        Queue::fake([
            Test::class,
        ]);
        $uri = route('job.1', ['rollback' => 'false']);
        $response = $this->get($uri, ['Accept' => 'application/json']);
        Queue::assertPushed(Test::class, 1);
        $response = $this->get(route('job.1', ['rollback' => 'true']), ['Accept' => 'application/json']);
        Queue::assertPushed(Test::class, 1);
        $response = $this->get(route('job.1', ['rollback' => 'false']), ['Accept' => 'application/json']);
        Queue::assertPushed(Test::class, 2);
    }
}
