<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_job()
    {
        $response = $this->post(route('api.job.1'));
        $response->assertStatus(200);

    }

    public function test_job1()
    {
        $response = $this->post(route('api.job.2'));
        $response->assertStatus(200);

    }
}
