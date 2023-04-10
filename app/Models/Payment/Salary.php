<?php

namespace App\Models\Payment;

use App\Enum\Payment;

class Salary extends PaymentType
{
    public function monthlyAmount(): int
    {
        return $this->employee->salary / 12;
    }

    public function type(): string
    {
        return Payment::SALARY->value;
    }

    public function amount(): int
    {
        return $this->employee->salary;
    }
}
