<?php

namespace utils;

class Calculator1 implements Calculator
{
    public function add(float|int $a, float|int $b): int|float
    {
        // TODO: Implement add() method.
        return $a + $b;
    }

    public function sub(float|int $a, float|int $b): int|float
    {
        // TODO: Implement sub() method.
        return $a - $b;
    }

    public function times(float|int $a, float|int $b): int|float
    {
        // TODO: Implement times() method.
        return $a * $b;
    }

    public function divide(float|int $a, float|int $b): int|float
    {
        // TODO: Implement divide() method.
        return $a / $b;
    }
}
