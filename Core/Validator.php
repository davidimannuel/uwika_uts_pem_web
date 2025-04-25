<?php

namespace Core;

class Validator
{
    public static function string($value, $min = 1, $max = INF)
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function greaterThan(int $value, int $greaterThan): bool
    {
        if ($value === null) {
            return false;
        }
        return $value > $greaterThan;
    }
}