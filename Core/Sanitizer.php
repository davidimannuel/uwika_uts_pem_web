<?php

namespace Core;

class Sanitizer
{

    public static function emptyToDefault($value, $default = null)
    {
        if ($value === null) {
            return $default;
        }
        return $value === '' ? $default : $value;
    }
}