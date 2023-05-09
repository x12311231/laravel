<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\BeforeCanceledOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CancelUnPayOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    public int $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Order $order
    )
    {
        //
    }

//    public function fail($exception = null)
//    {
//    }
//
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = $this->order->fresh(['user']);
        Log::debug('CancelUnPayOrder handle start:' . now());
        if (in_array($order->status, [Order::STATUS['paid'], Order::STATUS['canceled']])) {
            Log::debug('order has been paid or canceled');
            return;
        }
        if (Carbon::parse()->diffInMinutes(date('Y-m-d H:i:s', $order->create_at)) > 3 || $order->status == Order::STATUS['canceling']) {
            Log::debug('order is going to canceled');
            $order->canceled();
            return;
        }
        if ($order->status == Order::STATUS['unPay']) {
//            $user = $order->user()->getRelated();
//            $order = $order->with('user')->first();
//            assert(isset($user->id));
            assert(true);
            Notification::send($order->getRelation('user'), new BeforeCanceledOrder($order));
            $order->canceling();
            $this->release(now()->addMinutes(1));
        }
    }
}
