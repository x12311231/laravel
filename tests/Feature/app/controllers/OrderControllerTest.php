<?php

namespace Tests\Feature\app\controllers;

use App\Jobs\CancelUnPayOrder;
use App\Models\Order;
use App\Models\User;
use App\Notifications\BeforeCanceledOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Queue\Queue;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;

class OrderControllerTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_store()
    {
        \Illuminate\Support\Facades\Notification::fake();
//        \Illuminate\Support\Facades\Queue::fake([
//            CancelUnPayOrder::class,
//        ]);
        Notification::assertNothingSent();
        Carbon::setTestNow(now()->subMinutes(1));
        echo 'now:' . now();
        $user = User::where(['email' => '1434970057@qq.com'])->firstOr(function () {
            return $user = User::factory(['email' => '1434970057@qq.com'])
                ->create();
        });
        $this->actingAs($user);
        $countOrder = Order::count();
        $response = $this->post(route('order.store'), ['Accept' => 'application/json']);
//        \Illuminate\Support\Facades\Queue::pushedJobs();
//        \Illuminate\Support\Facades\Queue::pushed(CancelUnPayOrder::class);
//        \Illuminate\Support\Facades\Queue::pop();
//        \Illuminate\Support\Facades\Queue::assertPushed(CancelUnPayOrder::class, 1);
        Notification::assertSentTo([$user], BeforeCanceledOrder::class);
//        \Illuminate\Support\Facades\Queue::assertPushedOn('order', BeforeCanceledOrder::class);
        $this->assertDatabaseCount(Order::class, 1 + $countOrder);
        $response->assertOk();
        $response->assertContent('ok');
    }
}
