<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'paid_at',
        'status',
    ];

    const STATUS = [
        'unPay' => 'unPay',
        'paid' => 'paid',
        'canceling' => 'canceling',
        'canceled' => 'canceled',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canceling()
    {
        return $this->where(['status' => Order::STATUS['unPay'], 'id' => $this->id])
            ->update(['status' => Order::STATUS['canceling']]);
    }

    public function canceled()
    {
        return $this->whereOr(['status' => Order::STATUS['unPay'], 'status' => Order::STATUS['canceling']])
            ->where(['id' => $this->id])
            ->update(['status' => Order::STATUS['canceled']]);
    }

    public function pay()
    {
        $order = $this->fresh();
        if ($order->status == Order::STATUS['canceled']) {
            return false;
        }
        if ($order->status == Order::STATUS['paid']) {
            return true;
        }
        return $this->where(['id' => $this->id])->update(['status' => Order::STATUS['paid'], 'paid_at' => Carbon::now()->toDateTime()]);
    }
}
