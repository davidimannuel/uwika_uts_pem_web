<?php

namespace Core;

class Sanitizer
{

    public static function emptyToDefault($value, $default = null)
    {
        return $value === '' ? $default : $value;
    }
}