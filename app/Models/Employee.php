<?php

namespace App\Models;

use App\Enum\Payment;
use App\Models\Payment\PaymentType;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use HasUuid;
//    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'full_name',
        'email',
        'department_id',
        'job_title',
        'payment_type',
        'salary',
        'hourly_rate',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'department_id' => 'integer',
    ];

    public function paychecks(): HasMany
    {
        return $this->hasMany(Paycheck::class);
    }

    public function timelogs(): HasMany
    {
        return $this->hasMany(Timelog::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getPaymentTypeAttribute(): PaymentType
    {
        return Payment::from($this->original['payment_type'])->makePaymentType($this);
    }
}
