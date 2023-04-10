<?php

namespace App\Models\Payment;

use App\Enum\Payment;
use App\Models\TimeLog;

class HourlyRate extends PaymentType
{
    public function monthlyAmount(): int
    {
        // 工作时长 = 每月工作总分钟数 / 60
        $hoursWorked = TimeLog::query()
                ->where(['employee_id' => $this->employee->id])
                ->whereBetween('stopped_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])
                ->sum('minutes') / 60;

        // 月薪 = 四舍五入(时长) * 时薪
        return round($hoursWorked) * $this->employee->hourly_rate;
    }

    public function type(): string
    {
        return Payment::HOURLY_RATE->value;
    }

    public function amount(): int
    {
        return $this->employee->hourly_rate;
    }
}
