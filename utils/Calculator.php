<?php

namespace utils;

interface Calculator
{
    public function add(int | float $a, int | float $b): int | float;

    public function sub(int | float $a, int | float $b): int | float;

    public function times(int | float $a, int | float $b): int | float;

    public function divide(int | float $a, int | float $b): int | float;
}
