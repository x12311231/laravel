<?php

namespace App\Enum;

use App\Models\Employee;
use App\Models\Payment\HourlyRate;
use App\Models\Payment\Salary;

enum Payment: string
{
    case SALARY = 'salary';
    case HOURLY_RATE = 'hourly_rate';

    public function makePaymentType(Employee $employee): HourlyRate|Salary
    {
        return match ($this) {
            self::HOURLY_RATE => new HourlyRate($employee),
            Self::SALARY => new Salary($employee),
        };
    }
}
