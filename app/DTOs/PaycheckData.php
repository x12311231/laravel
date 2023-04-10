<?php

namespace App\DTOs;

class PaycheckData
{
    public function __construct(
        public readonly int $employee_id,
        public readonly float $net_amount,
        public readonly int $pay_at,
    )
    {
    }
}
