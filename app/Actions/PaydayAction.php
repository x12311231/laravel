<?php

namespace App\Actions;

use App\Models\Employee;

class PaydayAction
{
    public function execute(): void
    {
        foreach (Employee::all() as $employee) {
            $amount = $employee->payment_type->monthlyAmount();
            if ($amount == 0) {
                continue;
            }
            // 默认当月工资当月发完，都是好老板，否则还得考虑上月
            $count = $employee
                ->paychecks()
                ->whereBetween('created_at', [
                    now()->startOfMonth(),
                    now()->endOfMonth()
                ])
                ->count();
            if ($count > 0) {
                continue;
            }
            $employee->paychecks()->create([
                'net_amount' => $employee->payment_type->monthlyAmount(),
                'payed_at' => now(),
            ]);
        }
    }
}
